<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::get()->take(4)->sortByDesc('id');
        return view('frontend.index', compact('blogs'));
    }
}
