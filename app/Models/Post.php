<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'body', 'image', 'status'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
    function category()
    {
        return $this->belongsTo(Category::class);
    }
    function comments()
    {
        return  $this->hasMany(Comment::class);
    }
}
