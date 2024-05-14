<?php

namespace App\Http\Controllers;

use App\Services\V1\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrationService
    )  { }

    public function sendOtp(Request $request)
    {
        $number = $request->input('number');

        // Send OTP to the number
        return $this->registrationService->sendOtp();
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->input('otp');

        // Verify the OTP
        return $this->registrationService->verifyOtp();
    }
}
