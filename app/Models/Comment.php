<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'body'];
    function post()
    {
        return  $this->belongsTo(Post::class);
    }
    function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
