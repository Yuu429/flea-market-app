<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'description',
        'img_url',
        'condition',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->likedUsers()->where('user_id', $user->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getIsSoldAttribute()
    {
        return $this->purchase()->exists();
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
