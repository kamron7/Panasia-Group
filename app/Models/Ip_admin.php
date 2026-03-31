<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ip_admin extends Base
{
    use HasFactory;

    protected $table = 'ip_admin';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'id', 'ip_address', 'name', 'status'
    ];

    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean',
    ];
}
