<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manage extends Base
{
    use HasFactory;

    protected $table = 'manages';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title', 'group', 'cat_id',
        'post', 'reception', 'phone',
        'images', 'sort_order',
        'created_at', 'updated_at',
        'status', 'alias',
    ];

    protected $casts = [
        'images' => 'object',
        'cat_id' => 'integer',
        'status' => 'boolean',
        'title' => 'object',
        'reception' => 'object',
        'post' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public function children()
    {
        return $this->hasMany(Manage::class, 'cat_id', 'id')->where('status', true)->orderBy('sort_order', 'asc');
    }


}
