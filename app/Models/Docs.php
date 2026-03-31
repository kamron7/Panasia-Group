<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Docs extends Base
{
    use HasFactory;

    protected $table = 'docs';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'cat_id',
        'id',
        'title', 'content', 'group', 'files',
        'sort_order',
        'status', 'alias',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'title' => 'object',
        'content' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
        'cat_id' => 'integer',
        'status' => 'boolean',
        'files' => 'object',
    ];
}
