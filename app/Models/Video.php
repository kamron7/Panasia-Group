<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Base
{
    use HasFactory;

    protected $table = 'video';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title', 'files', 'img',
        'code', 'type', 'content',
        'sort_order', 'status',
        'created_at', 'updated_at', 'alias',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
        'type' => 'integer',
        'status' => 'boolean',
        'files' => 'object',
        'code' => 'object',
        'title' => 'object',
        'content' => 'object',
    ];

    public function parent()
    {
        return $this->belongsTo(Video::class, 'parent_id');
    }



}
