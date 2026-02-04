<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Stores extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable = [
        'language_id',
        'network_id',
        'category_id',
        'name',
        'slug',
        'top_store',
        'description',
        'affiliate_url',
        'destination_url',
        'top_store',
        'title',
        'meta_tag',
        'meta_keyword',
        'meta_description',
        'status',
        'authentication',
        'store_image',
        'content',
        'about',
    ];

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
     public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function coupons()
    {
        return $this->hasMany(Coupons::class, 'store_id');
    }
    public function networks()
    {
        return $this->belongsTo(Networks::class, 'network_id');
    }
}
