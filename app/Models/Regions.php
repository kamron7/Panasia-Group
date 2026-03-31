<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Base
{
    use HasFactory;

    protected $table = 'regions';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'product_id', 'price',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'price' => 'integer',
        'product_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
