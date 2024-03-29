<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

use stdClass;

/**
 * Class CalendarResponse
 *
 * @package App\Helpers
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class CalendarResponse
{
    /**
     * @param string $message
     * @param int $code
     * @param null $data
     * @return JsonResponse
     */
    public static function success(string $message = '', int $code = 200, $data = null): JsonResponse
    {
        $response = [
            'success' => [
                'data' => $data,
                'message' => $message
            ]
        ];

        return response()->json($response, $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function error(string $message, int $code): JsonResponse
    {
        $data = [
            'errors' => [
                'message' => $message
            ]
        ];
        return response()->json($data, $code);
    }

    public static function multipleError(array $errors, int $code): JsonResponse
    {
        $errorDataArray = [];

        foreach ($errors as $param => $message) {

            $errorData          = new stdClass();
            $errorData->param   = $param;
            $errorData->message = $message;

            $errorDataArray[]   = $errorData;
        }

        return response()->json(
            ['errors' => $errorDataArray],
            $code
        );
    }
}