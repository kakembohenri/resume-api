<?php

namespace App\CustomHelpers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ReturnBase
{

    protected $msg;

    protected $statusCode;

    protected $list;

    protected $object;

    protected $validator;

    public function __construct($msg, $statusCode, $list, $object, $validator)
    {
        $this->msg = $msg;
        $this->statusCode = $statusCode;
        $this->list = $list;
        $this->object = $object;
        $this->validator = $validator;
    }

    public static function Object(string $msg, object $object, int $statusCode)
    {
        $result = [
            'result' => $object,
            'msg' => $msg,
            'statusCode' => $statusCode,
            'success' => true
        ];

        return response()->json($result, $statusCode);
    }

    public static function Error(string $msg, int $statusCode)
    {
        $result = [
            'msg' => $msg,
            'statusCode' => $statusCode,
            'success' => false
        ];

        return response()->json($result, $statusCode);
    }

    public static function JustMessage(string $msg, int $statusCode)
    {
        $result = [
            'msg' => $msg,
            'statusCode' => $statusCode,
            'success' => false
        ];

        return response()->json($result, $statusCode);
    }

    public static function InternalServerError(string $msg)
    {
        Log::Error($msg);
        return response()->json(['msg' => 'Service Is Temporarily Down', 'StatusCode' => Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function HandleValidationErrors($validator)
    {
        $errors = $validator->errors();
        $result = [
            'msg' => $errors,
            'statusCode' => Response::HTTP_BAD_REQUEST,
            'success' => false,
        ];
        return response()->json($result, Response::HTTP_BAD_REQUEST);
    }
}
