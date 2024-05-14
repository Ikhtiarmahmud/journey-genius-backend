<?php

namespace App\Services\V1;

use App\Services\ApiBaseService;

class RegistrationService extends ApiBaseService
{
    public function sendOtp()
    {
        $data = [
            'validation_time' => 60,
            'otp' => '1234'
        ];

        return $this->sendSuccessResponse($data, 'OTP sent successfully');
    }

    public function verifyOtp()
    {
        $data = [
            'access_token' => '1234567890',
            'refresh_token' => '0987654321',
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ];

        return $this->sendSuccessResponse($data, 'OTP verified successfully');
    }
}
