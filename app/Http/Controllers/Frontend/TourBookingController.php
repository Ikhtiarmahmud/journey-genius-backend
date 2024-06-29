<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AgencyTour;
use App\Models\TourBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourBookingController extends Controller
{
    public function index($agencyTourId)
    {
        $bookings = TourBooking::where('agency_tour_id', $agencyTourId)->get();
        return view('frontend.admin.agency-tour.bookings', compact('bookings'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validation = AgencyTour::where('id', $request->agency_tour_id)->where('status', '!=', 'created')->first();

        if ($validation) {
            return redirect()->back()->with('error', 'This event due date is already over!');
        }

        $checkExists = TourBooking::where('phone', $request->phone)->where('agency_tour_id', $request->agency_tour_id)->first();

        if ($checkExists) {
            return redirect()->back()->with('error', 'This number is already used for booking!');
        }

        $data['user_id'] = Auth::id();
        $data['payment_status'] = 'pending';

        TourBooking::create($data);

        return redirect()->back()->with('success', 'Tour Booked Successfully');
    }
}
