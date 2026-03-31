<?php

namespace App\Models;

class Appeal extends Base
{
    protected $table = 'appeal';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'fio', 'email', 'phone', 'type',
        'address', 'message', 'ip',
        'file', 'code', 'access_code', 'status',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'address' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
