<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Base
{

    use HasFactory;

    protected $table = 'city';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'cat_id',
        'title',
        'status',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'title' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cat_id' => 'integer',
    ];

}
