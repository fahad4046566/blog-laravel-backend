<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use  App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Cloudinary;

class PostController extends Controller
{

    // it is responsible to show all posts with pagination, filter and search
    function index(Request $request)
    {
        $query = Post::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        $posts = $query->latest()->paginate(10);
        return response()->json($posts);
    }
    // it is responsible to show  posts that is search by slug
    function show($slug)
    {
        $post = Post::with('comments.user')->where('slug', $slug)->first();
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => new PostResource($post)
        ]);
    }
    // it is responsible to store or add all posts

    function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:drafted,public',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ]);
        if ($request->hasFile('image')) {
            $uploadResult = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath());
            $imageUrl = $uploadResult['secure_url'];
        }

        $post = new Post();
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        $post->slug = Str::slug($request->title);
        $post->image = $imageUrl;
        $post->status = $request->status;
        $post->user_id = Auth::id();
        $post->save();

        return response()->json(
            [
                'success' => true,
                "result" => [
                    "message" => "Post added successfully",
                    'data' => new PostResource($post)
                ]
            ]
        );
    }
    function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:drafted,public',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'errors' => "Id not found"
            ], 404);
        }
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ]
        ]);
        $imageUrl = $post->image;
        if ($request->hasFile('image')) {
            $uploadResult = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath());
            $imageUrl = $uploadResult['secure_url'];
        }
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        $post->slug = Str::slug($request->title);
        $post->image = $imageUrl;
        $post->status = $request->status;
        $post->save();

        return response()->json(
            [
                'success' => true,
                "result" => [
                    "message" => "Post updated successfully",
                    'data' => new PostResource($post)
                ]
            ]
        );
    }
    function delete($id)
    {
        $rules = [
            'id' => 'required|integer|exists:posts,id'
        ];

        $validator = Validator::make(['id' => $id], $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $post = Post::find($id);
        $post->delete();
        return response()->json(
            [
                'success' => true,
                "result" => [
                    "message" => "Post deleted successfully",
                ]
            ]
        );
    }
}
