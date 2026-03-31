<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Base
{
    use HasFactory;

    protected $table = 'region';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title',
        'id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'title' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
