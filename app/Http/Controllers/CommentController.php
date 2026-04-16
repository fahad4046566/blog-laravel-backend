<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|min:3|max:1000',
            'post_id' => 'required|exists:posts,id'
        ]);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();

         $comment->save();
    
   
    return response()->json([
        'success' => true,
        'message' => 'Comment added successfully',
        'data' => new CommentResource($comment)
    ], 201);
    }
    public function getCommentsCount()
{
    $count = Comment::count();
    return response()->json(['count' => $count]);
}
}
