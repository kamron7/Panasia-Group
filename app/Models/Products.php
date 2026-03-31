<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Base
{
    use HasFactory;

    protected $table = 'products';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'cat_id', 'views',
        'cat_id2', 'old_id',
        'title', 'content', 'content2','content3', 'content4','content5',
        'options', 'options2',
        'files', 'sort_order',
        'keywords', 'description',
        'id',
        'status', 'alias',
        'keywords', 'description',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'cat_id' => 'integer',
        'cat_id2' => 'integer',
        'files' => 'object',
        'status' => 'boolean',
        'title' => 'object',
        'content' => 'object',
        'content2' => 'object',
        'content3' => 'object',
        'content4' => 'object',
        'content5' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Main::class, 'parent_id');
    }


    public function children()
    {
        return $this->hasMany(Main::class, 'parent_id');
    }
}

