<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgencyTour;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyTourController extends Controller
{
    public function index()
    {
        $tours = AgencyTour::all();
        return view('frontend.admin.agency-tour.index', compact('tours'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('frontend.admin.agency-tour.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $image = $request->file('thumbnail');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $data['thumbnail'] = $imageName;
        $data['user_id'] = Auth::id();

        AgencyTour::create($data);

        return redirect()->route('agency-tours.index')->with('success', 'New Event Created Successfully');
    }

    public function edit($id)
    {
        $tour = AgencyTour::find($id);
        return view('frontend.admin.agency-tour.edit', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        $tour = AgencyTour::find($id);
        $data = $request->all();

        if ($request->file('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['thumbnail'] = $imageName;
        }

        $tour->update($data);

        return redirect()->route('agency-tours.index')->with('success', 'Event Updated Successfully');
    }

    public function destroy($id)
    {
        AgencyTour::find($id)->delete();

        return redirect()->route('agency-tours.index')->with('success', 'Event Deleted Successfully');
    }
}
