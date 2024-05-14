<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;

interface ApiBaseServiceInterface
{
    public function sendSuccessResponse($result, $message, $pagination, $http_status, $status_code): JsonResponse;

    public function sendErrorResponse($message, $errorMessages, $status_code): JsonResponse;
}
