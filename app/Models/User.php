<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Content;
use App\Models\Media;
use App\Models\Comment;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'name', 'password', 'role', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEditor()
    {
        return $this->role === 'editor';
    }

    public function isAuthor()
    {
        return $this->role === 'author'; // ← CORRECT: only author
    }

    public function isCreator()
    {
        return in_array($this->role, ['admin', 'editor', 'author', 'creator']);
    }

    public function canCreateContent()
    {
        return in_array($this->role, [
            'admin',
            'editor',
            'author',
            'content_creator'
        ]);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isSubscriber()
    {
        return $this->role === 'subscriber';
    }
}