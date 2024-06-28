<?php

namespace App\Http\Controllers\Admin;

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
        return view('frontend.admin.blog.index', compact('blogs'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('frontend.admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($request->title);
//        $data['image'] = $request->file('image')->store('images/blogs');
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;

        Blog::create($data);

        return redirect()->route('tours.index')->with('success', 'Blog Created Successfully');
    }
}
