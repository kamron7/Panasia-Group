<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Online;
use Illuminate\Http\Request;

class OnlineController extends PublicController
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'message' => 'required',
        ]);

        $ip = $request->header('X-Forwarded-For') ?? $request->ip();
        Online::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'birthday' => $validated['birthday'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'message' => $validated['message'],
            'ip' => $ip,
        ]);

        return redirect()->back()
            ->with([
                'success' => 'Your form has been submitted.',
            ]);
    }
}

