<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Appeal;
use App\Mail\FeedbackReceived;
use App\Models\Feedback;
use App\Models\DatasetRating;
use App\Models\DatasetComment;
use App\Models\Polls;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;


class FormsController extends PublicController
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'fio' => 'required',
//            'email' => 'required|email',
            'phone' => 'required',
//            'address' => 'required',
            'message' => 'required',
//            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        $originalFileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();
            $filePath = $file->store("uploads/feedback", 'public');
        }

        $code = rand(1000, 99999);
        $ip = $request->header('X-Forwarded-For') ?? $request->ip();

        $feedback = Feedback::create([
            'fio'     => $validated['fio'],
            'phone'   => $validated['phone'],
            'message' => $validated['message'],
        ]);

//        session()->put([
//            'submission_time' => now()->timestamp,
//            'last_code' => $feedback->id,
//            'last_access_code' => $code,
//        ]);


//        $chatId = env('TELEGRAM_CHAT_ID');
//        $message = "📩 *New Submission*\n\n"
//            . "*IP Address:* " . $ip . "\n"
//            . "*Name:* " . $validated['fio'] . "\n"
//            . "*Address:* " . $validated['address'] . "\n"
//            . "*Phone:* " . $validated['phone'] . "\n"
//            . "*Email:* " . $validated['email'] . "\n"
//            . "*Message:* " . ($validated['message'] ?? 'No message') . "\n"
//            . "*Submission ID:* " . $feedback->id . "\n"
//            . "*Access Code:* " . $feedback->access_code . "\n"
//            . "*Submission Date:* " . now()->format('d.m.Y H:i:s');
//
//        Telegram::sendMessage([
//            'chat_id' => $chatId,
//            'text' => $message,
//            'parse_mode' => 'Markdown',
//        ]);
//
//        if ($filePath) {
//            Telegram::sendDocument([
//                'chat_id' => $chatId,
//                'document' => InputFile::create(Storage::disk('public')->path($filePath), $originalFileName),
//                'caption' => $originalFileName,
//            ]);
//        }

        return redirect()->back()
            ->with([
//                'last_code' => $feedback->id,
//                'last_access_code' => $code,
                'submission_time' => now()->timestamp
            ]);

    }



    public function contact(Request $request)
    {
        // Captcha check
        $captchaInput = strtolower(trim($request->input('captcha_code', '')));
        $captchaSession = strtolower(trim(session('captcha_code', '')));
        if (empty($captchaInput) || $captchaInput !== $captchaSession) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['captcha_code' => 'Invalid captcha. Please try again.']);
        }
        session()->forget('captcha_code');

        $validated = $request->validate([
            'fio'     => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $ip = $request->header('X-Forwarded-For') ?? $request->ip();

        $fullMessage = $validated['message'];
        if (!empty($validated['subject'])) {
            $fullMessage = '[' . $validated['subject'] . '] ' . $fullMessage;
        }

        Feedback::create([
            'fio'     => $validated['fio'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'message' => $fullMessage,
        ]);

        return redirect()->back()->with('form_success', true);
    }


    public function submitRating(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:50',
            'ip'     => 'nullable|string|max:45',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $ip = $validated['ip'] ?: $request->ip();

        DatasetRating::updateOrCreate(
            [
                'name' => $validated['name'],
                'ip'   => $ip,
            ],
            [
                'rating' => $validated['rating'],
            ]
        );

        $count = DatasetRating::where('name', $validated['name'])->count();
        $avg   = DatasetRating::where('name', $validated['name'])->avg('rating');

        return response()->json([
            'success' => true,
            'count'   => $count,
            'avg'     => round((float)$avg, 2),
        ]);
    }


    public function submitComment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:50',
            'comment' => 'required|string|max:5000',
        ]);

        $ip = $request->ip();

        DatasetComment::create([
            'name'       => $validated['name'],
            'ip_address' => $ip,
            'comment'    => $validated['comment'],
        ]);

        return response()->json([
            'success' => true,
            'message' => p_lang('accept') ?? 'Saved',
        ]);
    }

    public function vote(Request $request): JsonResponse
    {
        $data = $request->validate([
            'poll_id' => ['required', 'integer', 'exists:polls,id'],
            'option'  => ['required', Rule::in([
                'option1', 'option2', 'option3', 'option4', 'option5', 'option6'
            ])],
        ]);

        $poll = Polls::findOrFail($data['poll_id']);

        $column = $data['option'] . '_votes';

        if (! in_array($column, [
            'option1_votes', 'option2_votes', 'option3_votes',
            'option4_votes', 'option5_votes', 'option6_votes',
        ], true)) {
            return response()->json(['success' => false], 400);
        }

        $poll->increment($column);

        return response()->json([
            'success' => true,
        ]);
    }
}
