<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AgencyTour;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::get()->take(4)->sortByDesc('id');
        $tours = AgencyTour::take(6)->get();
        return view('frontend.index', compact('blogs', 'tours'));
    }
}
