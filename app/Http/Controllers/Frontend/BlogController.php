<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('frontend.blog-grid', compact('blogs'));
    }

    public function details($id)
    {
        $blog = Blog::find($id);
        $categories = Category::all();
        $recentBlogs = Blog::take(5)->get();
        return view('frontend.blog-details', compact('blog', 'categories', 'recentBlogs'));
    }
}
