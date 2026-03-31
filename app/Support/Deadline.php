<?php
namespace App\Support;

use App\Models\Application;
use App\Models\Main;
use Illuminate\Support\Carbon;

class Deadline
{
    public static function global(): ?Carbon
    {
        $row = Main::query()
            ->where('group','deadline')
            ->latest('id')
            ->first();

        return $row?->created_at?->copy();
    }

    public static function effective(?Application $app): ?Carbon
    {
        return static::global();

    }

    public static function isClosed(?Application $app): bool
    {
        $dl = static::global();
        return $dl ? now()->greaterThan($dl) : false;
    }
}


