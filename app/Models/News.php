<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Base
{
    use HasFactory;

    protected $table = 'news';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'cat_id',
        'title', 'content', 'short_content', 'images', 'video_code',
        'views', 'options',
        'status', 'alias',
        'keywords', 'description', 'group',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'title' => 'object',
        'content' => 'object',
        'short_content' => 'object',
        'video_code' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'views' => 'integer',
        'status' => 'boolean',
        'options' => 'boolean',
        'images' => 'object',
    ];


}
