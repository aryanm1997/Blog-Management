<?php

namespace App\Models;
use App\Models\User;


use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'image'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class, 'blog_user_views')->withTimestamps();
    }
    // Blog.php
    public function viewedByUsers()
    {
        return $this->belongsToMany(User::class, 'blog_user_views')->withTimestamps();
    }

}

