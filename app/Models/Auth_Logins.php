<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auth_Logins extends Base
{
    use HasFactory;

    protected $table = 'auth_logins';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'id', 'ip_address', 'ban', 'ban_time', 'attempt', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'attempt' => 'integer',
        'ban' => 'boolean',
        'ban_time' => 'datetime',
    ];
}
