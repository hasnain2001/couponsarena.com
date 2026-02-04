<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'category_image',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'top',
        'category_id',
        'language_id',
        'status',
    ];

        public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
