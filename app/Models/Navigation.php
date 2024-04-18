<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $fillable = [
        'title', 'type', 'route', 'index', 'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Define default values for attributes if they are not provided
        $this->attributes = array_merge([
            'title' => '', // Default value for title
            'type' => '', // Default value for type
            'route' => '',
        ], $this->attributes);
    }
}
