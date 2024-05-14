<?php

namespace App\Services;

use App\Enums\ApiCustomStatusCode;
use App\Enums\HttpStatusCode;
use Illuminate\Http\JsonResponse;
use App\Contracts\ApiBaseServiceInterface;
use Illuminate\Support\Facades\Config;

/**
 * Class ApiBaseService
 * @package App\Services
 */
class ApiBaseService implements ApiBaseServiceInterface
{
    /**
     * Success response method.
     *
     * @param array|null $result
     * @param $message
     * @param array $pagination
     * @param int $http_status
     * @param int $status_code
     * @return JsonResponse
     */
    public function sendSuccessResponse(
        $result,
        $message,
        $pagination = [],
        $http_status = HttpStatusCode::SUCCESS,
        $status_code = ApiCustomStatusCode::SUCCESS
    ): JsonResponse {
        $response = [
            'status' => 'SUCCESS',
            'status_code' => $status_code,
            'message' => $message,
            'data' => $result
        ];

        if (!empty($pagination)) {
            $response ['pagination'] = $pagination;
        }

        return response()->json($response, $http_status)->withHeaders([]);
    }

    public function sendSuccessResponseWithMetaData(
        $data,
        $message,
        $metaData = [],
        $pagination = [],
        $http_status = HttpStatusCode::SUCCESS,
        $status_code = ApiCustomStatusCode::SUCCESS
    ): JsonResponse {
        $response = [
            'status' => 'SUCCESS',
            'status_code' => $status_code,
            'message' => $message,
            'data' => $data,
            '_metadata' => $metaData
        ];

        if (!empty($pagination)) {
            $response ['pagination'] = $pagination;
        }

        return response()->json($response, $http_status);
    }


    public function sendErrorResponse($message, $errorMessages = [], $status_code = HttpStatusCode::VALIDATION_ERROR): JsonResponse
    {
        $errorCode = $errorMessages['code'] ?? '';

        if ($errorCode) {
            $errorCode = $errorCode . ': ';
        }

        $response = [
            'status' => 'FAIL',
            'status_code' => $status_code,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            if (!empty($errorMessages['message'])) {
                $errorMessages['message'] = $errorCode . $errorMessages['message'];
            }

            $response['error'] = $errorMessages;
        }

        return response()->json($response, $status_code);
    }
}
