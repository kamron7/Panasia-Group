<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Base
{
    use HasFactory;

    protected $table = 'pages';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title', 'content', 'short_content', 'html_content',
        'files', 'options',
        'created_at', 'updated_at',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'boolean',
        'files' => 'object',
        'title' => 'object',
        'content' => 'object',
        'short_content' => 'object',
        'html_content' => 'object',
    ];
}
