<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Base
{
    use HasFactory;

    protected $table = 'site';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title', 'email','content',
        'status',
        'keywords', 'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'category_id' => 'integer',
        'status' => 'boolean',
        'title' => 'object',
        'content' => 'object',
    ];
}
