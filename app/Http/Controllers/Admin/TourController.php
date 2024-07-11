<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\TourAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index()
    {
        $tours = TourAlbum::where('user_id', Auth::id())->get();
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
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;

        TourAlbum::create($data);

        return redirect()->route('tours.index')->with('success', 'Album Created Successfully');
    }

    public function edit($id)
    {
        $tour = TourAlbum::find($id);
        return view('frontend.admin.tour.edit', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        $tour = TourAlbum::find($id);
        $data = $request->all();

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['blog'] = $imageName;
        }

        $tour->update($data);

        return redirect()->route('tours.index')->with('success', 'Album Updated Successfully!');
    }

    public function destroy($id)
    {
        TourAlbum::find($id)->delete();

        return redirect()->route('tours.index')->with('success', 'Album Deleted Successfully!');
    }
}
