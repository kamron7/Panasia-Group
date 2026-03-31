<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DeadlineController extends Controller
{
    public function update(Request $r)
    {
        $data = $r->validate([
            'deadline_at' => ['required','date'],
        ]);

        $ts = Carbon::parse($data['deadline_at'])->timezone(config('app.timezone', 'UTC'));

        $row = Main::firstOrCreate(
            ['group' => 'deadline'],
            ['status' => true]
        );

        DB::table('main')->where('id', $row->id)->update(['created_at' => $ts]);

        return response()->json([
            'ok' => true,
            'deadline_iso' => $ts->toIso8601String(),
            'human' => $ts->isoFormat('DD.MM.YYYY HH:mm'),
        ]);
    }
}
