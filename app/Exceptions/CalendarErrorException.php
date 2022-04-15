<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 10:49
 */

namespace App\Exceptions;

use Exception;
use Throwable;

class CalendarErrorException extends  Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        $data = [
            'errors' => [
                'message' => $this->message
            ]
        ];
        return response()->json($data,$this->getCode());
    }
}