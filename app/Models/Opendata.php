<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opendata extends Base
{
    use HasFactory;

    protected $table = 'opendata';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'title',
        'id',
        'options',
        'downloads',
        'files', 'sort_order',
        'status', 'alias',
        'created_at', 'updated_at',
    ];

    protected $casts = [

        'files' => 'object',
        'status' => 'boolean',
        'title' => 'object',
        'created_at' => 'datetime',
        'downloads'  => 'integer',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

}

