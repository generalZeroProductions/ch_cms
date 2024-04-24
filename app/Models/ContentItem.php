<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
    protected $fillable = [
        'type','heading', 'title', 'body', 'index', 'data', 'styles', 'image'
    ];

    protected $casts = [
        'data' => 'array', 'styles' => 'array'
    ];
}
