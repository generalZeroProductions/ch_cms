<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'route', 'index', 'data', 'styles','parent'
    ];


    protected $casts = [
        'data' => 'array',
        'styles'=>'array'
    ];
}
