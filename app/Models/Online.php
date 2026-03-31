<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Online extends Base
{
    use HasFactory;

    protected $table = 'online';
    public function __construct()
    {
        parent::__construct($this->table);
    }
    protected $fillable = [
        'name',
        'birthday',
        'phone',
        'email',
        'address',
        'message',
        'reply',
        'created_at',
        'ip',
        'status',
    ];

    public $timestamps = false;

    protected $casts = [
        'birthday' => 'date',
        'created_at' => 'datetime',
        'status' => 'integer',
    ];
}
