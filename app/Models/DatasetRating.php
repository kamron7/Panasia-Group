<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatasetRating extends Base
{
    use HasFactory;

    protected $table = 'dataset_ratings';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [

        'id', 'rating', 'ip','name',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

}

