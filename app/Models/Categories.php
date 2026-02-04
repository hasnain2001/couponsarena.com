<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'title',
        'slug',
        'meta_tag',
        'meta_keyword',
        'meta_description',
        'status',
        'authentication',
        'category_image',
    ];

        // Category Model
    public function stores()
    {
        return $this->hasMany(Stores::class); 
    }
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id'); 
    }

}
