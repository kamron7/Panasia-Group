<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Virtual;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Main;

class VirtualFormController extends Controller
{
    public function store(Request $request)
    {
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');

        if (Cache::has("banned:$ip")) {
            return response()->json(['error' => 'Access denied. You have been temporarily banned.'], 403);
        }

        if (!$userAgent || Str::contains(strtolower($userAgent), ['bot', 'crawl', 'spider'])) {
            Cache::put("banned:$ip", true, now()->addHours(6));
            return response()->json(['error' => 'Bot detected.'], 403);
        }

        $key = "virtual_form:$ip";
        $maxAttempts = 5;
        $decayMinutes = 10;

        if (Cache::has($key)) {
            $data = Cache::get($key);
            if ($data['count'] >= $maxAttempts) {
                Cache::put("banned:$ip", true, now()->addMinutes(30));
                return response()->json(['error' => 'Too many requests. You are temporarily banned.'], 429);
            }
            $data['count']++;
            Cache::put($key, $data, now()->addMinutes($decayMinutes));
        } else {
            Cache::put($key, ['count' => 1], now()->addMinutes($decayMinutes));
        }

        if ($request->input('trap')) {
            Cache::put("banned:$ip", true, now()->addHours(12));
            return response()->json(['error' => 'Spam detected.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'required|string|max:100',
            'region' => 'required|integer|exists:main,id',
            'city' => 'required|integer|exists:main,id',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'required|string',
            'passport_data' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'person_type' => 'required|integer|exists:main,id',
            'gender' => 'required|integer|exists:main,id',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'request_type' => 'required|integer|exists:main,id',
            'request_text' => 'required|string|min:10',
            'file' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store("uploads/virtual", 'public');
        }

        $code = rand(1000, 99999);
        $access_code = md5($code);

        $virtual = Virtual::create([
            ...$validator->validated(),
            'file' => $filePath,
            'code' => $access_code,
            'access_code' => $code
        ]);

        return response()->json([
            'message' => 'Форма успешно отправлена.',
            'id' => $virtual->id,
            'access_code' => $code
        ], 201);
    }

    public function showByIdAndAccessCode($id, $access_code)
    {
        $record = Virtual::with(['region', 'city', 'requestType'])->where([
            ['id', '=', $id],
            ['access_code', '=', $access_code]
        ])->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID or Access Code.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'first_name' => $record->first_name,
                'last_name' => $record->last_name,
                'middle_name' => $record->middle_name,
                'email' => $record->email,
                'phone' => $record->phone,
                'address' => $record->address,
                'request_text' => $record->request_text,
                'file' => $record->file,
                'status' => $record->status ?? 0,
                'region' => $record->region->title ?? null,
                'city' => $record->city->title ?? null,
                'request_type' => $record->requestType->title ?? null,
            ]
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:0,1,3'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $record = Virtual::findOrFail($id);
            $record->status = $request->status;
            $record->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'status' => (int) $record->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }
}
