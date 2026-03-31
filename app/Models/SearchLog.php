<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'term',
        'user_id',
        'ip_address',
        'searched_at',
        'result_count',
        'search_type',
        'device_type',
        'session_id'
    ];

    protected $casts = [
        'searched_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePopular($query, $days = 30)
    {
        return $query->where('searched_at', '>=', now()->subDays($days))
            ->groupBy('term')
            ->orderByRaw('COUNT(*) DESC');
    }
}
