<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\SimpleXLSX;
use App\Http\Controllers\Controller;
use App\Models\AgencyTour;
use App\Models\Blog;
use App\Models\Category;
use App\Models\TourAlbum;
use App\Models\TourRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $monthName = strtolower($date->format('F'));
        $weatherName = 'Monsoon';

        $otherAlbums = TourAlbum::where('user_id', '!=', Auth::id())->where('ratings', '>=', 4)->pluck('location');
        $ownAlbums = TourAlbum::where('user_id', Auth::id())->pluck('location');

        $recommendedLocations = [];
        foreach ($otherAlbums as $album) {
            if (!in_array($album, $ownAlbums->toArray())) {
                $recommendedLocations[] = $album;
            }
        }

        return view('frontend.recommendation', compact('weatherName', 'recommendedLocations'));
    }

    public function details($location)
    {
        $tours = AgencyTour::all();
        $filePath = public_path('tour_places.xlsx');

        $xlsx = SimpleXLSX::parse($filePath);

        $details = [];

        foreach ($xlsx->rows() as $key => $r) {
            if ($key == 0) continue;

            if ($r[1] == $location) {
                $details['weather'] = $r[0];
                $details['location_name'] = config('tours.places.monsoon.' . $location);
                $details['desc'] = $r[2];
                $details['transport'] = $r[3];
                $details['hotel'] = $r[4];
                $details['special_food'] = $r[5];
                $details['special_hotel'] = $r[6];
            }
        }

        return view('frontend.recommendation-details', compact('tours', 'location', 'details'));
    }

    public function request(Request $request)
    {
       $data = $request->all();
       $data['user_id'] = Auth::id();

       TourRequest::create($data);

       return redirect()->back()->with('success', 'Requested Successfully to all agency');
    }
}
