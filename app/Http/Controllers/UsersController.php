<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $u = $request->user();
            if (!$u || !in_array($u->role ?? '', ['admin'], true)) {
                abort(403, 'This action is unauthorized.');
            }
            return $next($request);
        })->only([
            'index','show','updateStatus','attachments','destroy','bulkStatus','bulkDelete'
        ]);
    }

    public function index(Request $request)
    {
        $q = trim((string)$request->string('q'));
        $blocked = $request->filled('blocked') ? (int)$request->string('blocked') : null;

        $users = User::query()
            ->when($blocked !== null, fn($qq) => $qq->where('blocked', (bool)$blocked))
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('username', 'like', "%{$q}%")
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(20);

        return view('public.pages.admin-dashboard', [
            'applications' => null,
            'users' => $users,
            'categories' => null,
            'statuses' => [
                'submitted' => 'Отправлена',
                'precheck' => 'Предотбор',
                'accepted' => 'Принята',
                'rejected' => 'Отказано',
                'needs_more' => 'Нужны материалы',
                'draft' => 'Черновик',
            ],
        ]);
    }

    public function block(User $user)
    {
        $user->update(['blocked' => true]);
        return response()->noContent();
    }

    public function unblock(User $user)
    {
        $user->update(['blocked' => false]);
        return response()->noContent();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public function bulkBlock(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        User::whereIn('id', $data['ids'])->update(['blocked' => true]);
        return response()->noContent();
    }

    public function bulkUnblock(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        User::whereIn('id', $data['ids'])->update(['blocked' => false]);
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        User::whereIn('id', $data['ids'])->delete();
        return response()->noContent();
    }
}
