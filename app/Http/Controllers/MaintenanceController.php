<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'У вас нет разрешения на выполнение этого действия..');
        }

        try {
            if (app()->isDownForMaintenance()) {
                Artisan::call('up');
                $message = 'Режим обслуживания отключен — сайт снова доступен всем.';
            } else {
                Artisan::call('down', [
                    '--secret' => 'osg-secret',
                    '--retry' => 60
                ]);

                $message = 'Включен режим обслуживания';
            }

            return back()->with('success');
        } catch (\Exception $e) {
            return back()->with('error', 'Не удалось переключить режим обслуживания.: ' . $e->getMessage());
        }
    }
}
