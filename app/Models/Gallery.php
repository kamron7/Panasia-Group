<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Base
{
    use HasFactory;

    protected $table = 'gallery';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title','content', 'images',
        'sort_order',
        'status', 'alias',
        'keywords', 'description',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
        'status' => 'boolean',
        'images' => 'object',
        'title' => 'object',
        'content' => 'object',
    ];

}
