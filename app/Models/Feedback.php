<?php

namespace App\Models;

class Feedback extends Base
{
    protected $table = 'feedback';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'fio', 'email', 'phone',
        'address', 'message', 'file',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'address' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
