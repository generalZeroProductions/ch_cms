<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
    protected $fillable = [
        'type', 'title',  'body', 'index', 'data', 'styles'
    ];

    protected $casts = [
        'data' => 'array', 'styles' => 'array'
    ];
}
