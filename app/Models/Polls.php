<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polls extends Base
{
    use HasFactory;

    protected $table = 'polls';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
      'id', 'title', 'option1',  'option2', 'option3', 'option4', 'option5', 'option6',
      'option1_votes',  'option2_votes', 'option3_votes', 'option4_votes', 'option5_votes', 'option6_votes',
        'status'
    ];

    protected $casts = [
        'title' => 'object',
        'option1' => 'object',
        'option2' => 'object',
        'option3' => 'object',
        'status' => 'boolean',
        'option4' => 'object',
        'option5' => 'object',
        'option6' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

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

