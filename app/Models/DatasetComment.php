<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatasetComment extends Base
{
    use HasFactory;

    protected $table = 'dataset_comments';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [

        'id', 'comment', 'ip_address','name',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

}

