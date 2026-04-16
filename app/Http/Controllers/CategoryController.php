<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;


class CategoryController extends Controller
{
    function index()
    {
        $categories = Category::withCount('posts')->get();
        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories)
        ]);
    }
}
