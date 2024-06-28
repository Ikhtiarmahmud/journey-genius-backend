<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TourAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index()
    {
        $tours = TourAlbum::all();
        return view('frontend.admin.tour.index', compact('tours'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('frontend.admin.tour.create', compact('categories'));
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

        TourAlbum::create($data);

        return redirect()->route('tours.index')->with('success', 'Blog Created Successfully');
    }
}
