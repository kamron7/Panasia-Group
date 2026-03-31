<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationFile;
use Illuminate\Http\Request;
use App\Models\Main;
use App\Support\Deadline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $u = $request->user();
            if (!$u || !in_array($u->role ?? '', ['admin', 'user'], true)) {
                abort(403, 'This action is unauthorized.');
            }
            return $next($request);
        })->only([
            'index','show','updateStatus','attachments','destroy','bulkStatus','bulkDelete'
        ]);
    }

    public function apply(Request $r)
    {
        $userId = auth()->id();
        abort_if(!$userId, 401, 'Требуется авторизация.');

        $data = $r->validate([
            'org'           => ['required', 'string', 'max:255'],
            'brand'         => ['required', 'string', 'max:255'],
            'category'      => ['required','integer', Rule::exists('main','id')->where(fn($q)=>$q->where('group','categories')->where('status', true))],
            'city'          => ['nullable', 'string', 'max:255'],
            'about'         => ['string', 'max:10000'],
            'link'          => ['nullable', 'url', 'max:2000'],
            'contact_name'  => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email:rfc,dns', 'max:255'],
            'phone'         => ['required', 'string', 'max:50'],
            'files.*'       => [ File::types(['pdf','ppt','pptx','doc','docx','mp4','avi','mov'])->max(300*1024) ],
        ], [], ['category' => 'Категория']);

        $app = Application::firstOrNew(['user_id' => $userId]);

        if (Deadline::isClosed($app)) {
            return back()
                ->withErrors(['base' => 'Приём заявок закрыт — дедлайн истёк'])
                ->withInput();
        }
        if ($app->exists && (int)($app->submit_attempts ?? 0) >= 5) {
            return back()
                ->withErrors(['base' => 'Достигнут лимит: 5 отправки.'])
                ->withInput();
        }

        if (!$app->exists) {
            $app->user_id       = $userId;
            $app->submit_attempts = 0;
            $app->status        = 'draft';
        }

        Gate::authorize('update', $app);

        $app->fill([
            'org'           => $data['org'],
            'brand'         => $data['brand'],
            'category_id'   => (int)$data['category'],
            'city'          => $data['city'] ?? null,
            'about'         => $data['about'],
            'link'          => $data['link'] ?? null,
            'contact_name'  => $data['contact_name'],
            'email'         => Str::lower($data['email']),
            'phone'         => $data['phone'],
            'subscribe'     => (bool)$r->boolean('subscribe', true),
            'status'        => 'submitted',
            'submitted_at'  => now(),
        ]);

        $app->submit_attempts = (int)$app->submit_attempts + 1;
        $app->save();

        if ($r->hasFile('files')) {
            $this->storeFiles($app, $r->file('files'), $userId);
        }

        return back()->with('status', 'Заявка отправлена. Мы сообщим о решении по e-mail.');
    }

    public function upload(Request $r)
    {
        $user = $r->user();
        $app = Application::where('user_id', $user->id)->firstOrFail();

        Gate::authorize('upload', $app);
        if ($app->isFinal() || Deadline::isClosed($app)) {
            return back()->withErrors(['files' => 'Приём материалов закрыт.']);
        }

        $r->validate([
            'files.*' => [
                'required',
                File::types(['pdf', 'ppt', 'pptx', 'doc', 'docx', 'mp4', 'avi', 'mov'])->max(300 * 1024),
            ],
        ]);

        $this->storeFiles($app, $r->file('files'), $user->id);

        return back()->with('status', 'Файлы загружены.');
    }
    protected function storeFiles(Application $app, array $files, int $userId): void
    {
        foreach ($files as $file) {
            if (!$file->isValid()) continue;

            $ext = Str::lower($file->getClientOriginalExtension());
            $size = $file->getSize(); // bytes

            // Per-type hard limits (server-side mirror of your UI)
            $caps = [
                'video' => 300 * 1024 * 1024,
                'ppt' => 50 * 1024 * 1024,
                'doc' => 30 * 1024 * 1024,
                'pdf' => 50 * 1024 * 1024,
            ];
            $kind = in_array($ext, ['mp4', 'avi', 'mov']) ? 'video'
                : (in_array($ext, ['ppt', 'pptx']) ? 'ppt'
                    : (in_array($ext, ['doc', 'docx']) ? 'doc'
                        : 'pdf'));

            if ($size > ($caps[$kind] ?? (50 * 1024 * 1024))) {
                // skip oversize, or throw
                abort(422, "Файл {$file->getClientOriginalName()} превышает лимит.");
            }

            $disk = 'public';
            $dir = "applications/{$app->id}";
            $stored = $file->store($dir, $disk);

            ApplicationFile::create([
                'application_id' => $app->id,
                'uploaded_by' => $userId,
                'original_name' => $file->getClientOriginalName(),
                'stored_name' => basename($stored),
                'mime' => $file->getMimeType(),
                'size' => $size,
                'disk' => $disk,
                'path' => $stored,
            ]);
        }

        $app->files_count = $app->files()->count();
        $app->save();
    }
    public function setStatus(Request $r, Application $app)
    {
        $r->validate([
            'status' => ['required', Rule::in(['draft','submitted','precheck','accepted','rejected','needs_more'])],
            'admin_notes' => ['nullable','string','max:10000'],
        ]);

        Gate::authorize('update', $app); // ⬅ replace $this->authorize

        $app->status = $r->input('status');
        if (in_array($app->status, ['accepted','rejected'], true)) {
            $app->reviewed_at = now();
        }
        if ($r->filled('admin_notes')) $app->admin_notes = $r->string('admin_notes');
        $app->save();

        return back()->with('status', 'Статус обновлён.');
    }

    public function deleteFile(\App\Models\ApplicationFile $file)
    {
        $app = $file->application;

        Gate::authorize('upload', $app);


        if ($app->isFinal() || Deadline::isClosed($app)) {
            return response()->json(['ok' => false, 'message' => 'Приём материалов закрыт'], 423);
        }
       

        Storage::disk($file->disk)->delete($file->path);
        $file->delete();

        $app->files_count = $app->files()->count();
        $app->save();

        return response()->json(['ok' => true]);
    }

    public function index(Request $request)
    {
        $statuses = [
            'submitted'  => 'Отправлена',
            'precheck'   => 'Предотбор',
            'accepted'   => 'Принята',
            'rejected'   => 'Отказано',
            'needs_more' => 'Нужны материалы',
            'draft'      => 'Черновик',
        ];

        $q         = trim((string)$request->string('q'));
        $status    = $request->string('status')->toString() ?: null;
        $category  = $request->integer('category') ?: null;

        $apps = Application::query()
            ->with(['user:id,username,email', 'category:id,title'])
            ->withCount('files') // ⬅ add this
            ->when($status, fn($qq) => $qq->where('status', $status))
            ->when($category, fn($qq) => $qq->where('category_id', $category))
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('org', 'like', "%{$q}%")
                        ->orWhere('brand', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(20);


        $categories = Main::where('group','categories')->where('status', true)->get(['id','title']);

        return view('public.pages.admin-dashboard', compact('apps', 'categories', 'statuses'))
            ->with([
                'applications' => $apps,
                'users' => null,
            ]);
    }

    public function show(Application $application)
    {
        $application->load(['user', 'category', 'files']);
        return view('public/pages/application-show', compact('application'));
    }
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => ['required', Rule::in(['submitted','precheck','accepted','rejected','needs_more','draft'])],
        ]);

        $application->update(['status' => $request->string('status')]);
        return response()->noContent(); // 204
    }

    public function attachments(Application $application)
    {
        $application->load('files');

        $files = $application->files->map(fn($f) => [
            'id'            => $f->id,
            'original_name' => $f->original_name ?? basename($f->path),
            'url'           => $f->url,
        ]);

        return response()->json(['files' => $files]);
    }


    public function destroy(Application $application)
    {
        $application->delete();
        return response()->noContent();
    }
    public function bulkStatus(Request $request)
    {
        $data = $request->validate([
            'ids'    => ['required','array','min:1'],
            'ids.*'  => ['integer','exists:applications,id'],
            'status' => ['required', Rule::in(['submitted','precheck','accepted','rejected','needs_more','draft'])],
        ]);

        Application::whereIn('id', $data['ids'])->update(['status' => $data['status']]);
        return response()->noContent();
    }
    public function bulkDelete(Request $request)
    {
        $data = $request->validate([
            'ids'   => ['required','array','min:1'],
            'ids.*' => ['integer','exists:applications,id'],
        ]);

        Application::whereIn('id', $data['ids'])->delete();
        return response()->noContent();
    }

}
