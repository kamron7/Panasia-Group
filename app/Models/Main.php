<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Base
{
    use HasFactory;

    protected $table = 'main';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'cat_id', 'views',
        
        'title', 'short_content', 'content',
        'group', 'options', 'options2',
        'files', 'sort_order',
        'id',
        'status', 'alias',
        'keywords', 'description',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'cat_id' => 'integer',
        'files' => 'object',
        'status' => 'boolean',
        'title' => 'object',
        'content' => 'object',
        'short_content' => 'object',
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

