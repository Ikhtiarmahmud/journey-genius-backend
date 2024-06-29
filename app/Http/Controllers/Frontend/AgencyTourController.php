<?php

namespace App\Http\Controllers\Frontend;

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
        return view('frontend.agency', compact('tours'));
    }

    public function details($id)
    {
        $tour = AgencyTour::find($id);
        return view('frontend.agency-details', compact('tour'));
    }
}
