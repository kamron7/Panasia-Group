<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;
use Exception;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'visits';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'referrer',
        'path',
        'device',
        'platform',
        'browser',
        'is_robot',
        'country',
        'city',
    ];

    public static function record(): ?self
    {
        try {
            $agent = new Agent();
            $ip = request()->ip();
            $userAgent = substr(request()->userAgent(), 0, 500);

            $recentVisit = self::where('user_agent', $userAgent)
                ->where('created_at', '>=', now()->subHour())
                ->first();

            if ($recentVisit) {
                return null;
            }

            $geoIpData = self::getGeoIpData($ip);

            return self::create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'referrer' => request()->header('referer'),
                'path' => request()->path(),
                'device' => $agent->device() ?? 'unknown',
                'platform' => $agent->platform() ?? 'unknown',
                'browser' => $agent->browser() ?? 'unknown',
                'is_robot' => $agent->isRobot(),
                'country' => $geoIpData['country'] ?? null,
                'city' => $geoIpData['city'] ?? null,
            ]);
        } catch (Exception $e) {
            report($e);
            return null;
        }
    }


    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
    }

    public function isMobile(): bool
    {
        return $this->device && strtolower($this->device) === 'mobile';
    }

    public function isTablet(): bool
    {
        return $this->device && strtolower($this->device) === 'tablet';
    }

    public function isDesktop(): bool
    {
        if (!$this->device) return false;

        $device = strtolower($this->device);
        return $device === 'desktop' ||
            (!in_array($device, ['mobile', 'tablet']) && !$this->isRobot());
    }

    public function isSameVisitor(Visit $visit): bool
    {
        return $this->ip_address === $visit->ip_address &&
            $this->user_agent === $visit->user_agent;
    }

    protected static function getGeoIpData(string $ip): array
    {
        if (app()->environment('local')) {
            return [
                'country' => 'Uzbekistan',
                'city' => 'Uzbekistan'
            ];
        }

        try {
            if (function_exists('geoip') && !empty($ip) && $ip !== '127.0.0.1') {
                $geo = geoip($ip);
                return [
                    'country' => $geo->country ?? null,
                    'city' => $geo->city ?? null
                ];
            }
        } catch (Exception $e) {
            report($e);
        }

        return [
            'country' => null,
            'city' => null
        ];
    }
}
