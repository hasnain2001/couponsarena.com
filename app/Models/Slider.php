<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'title',
        'image_path',
        'link',
        'order',
        'is_active',
    ];
    protected $casts = [
        'order' => 'integer',
        'is_active' => 'boolean',
    ];
}
