<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencyTour;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('user_id', Auth::id())->get();
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
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;

        Blog::create($data);

        return redirect()->route('tours.index')->with('success', 'Blog Created Successfully');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $blog = Blog::find($id);
        return view('frontend.admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $data = $request->all();

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Blog Updated Successfully!');
    }

    public function destroy($id)
    {
        Blog::find($id)->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog Deleted Successfully!');
    }
}
