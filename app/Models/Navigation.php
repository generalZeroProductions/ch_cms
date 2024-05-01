<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'route', 'index', 'data', 'styles'
    ];

    protected $casts = [
        'data' => 'array',
        'style'=>'array'
    ];
}
