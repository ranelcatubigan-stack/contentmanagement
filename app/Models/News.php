<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id', 'title', 'body', 'photo', 'category', 'likes_count'
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function comments()
    {
        return $this->hasMany(NewsComment::class)->with('user')->latest();
    }
 
    public function likes()
    {
        return $this->hasMany(NewsLike::class);
    }
 
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
