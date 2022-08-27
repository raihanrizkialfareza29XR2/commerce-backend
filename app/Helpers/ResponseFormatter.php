<?php

namespace App\Helpers;

class ResponseFormatter
{
  protected static $response = [
    'meta' => [
      'code' => 200,
      'status' => 'success',
      'message' => null
    ],
    'data' => null
  ];
  
  protected static $responses = [
    'meta' => [
      'code' => 200,
      'status' => 'success',
      'message' => null
    ],
    'data' => null,
    'count' => null
  ];

  public static function success($data = null, $message = null)
  {
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;

    return response()->json(self::$response, self::$response['meta']['code']);
  }
  
  public static function successes($data = null, $datas = null,  $message = null)
  {
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;
    self::$response['count'] = $datas;

    return response()->json(self::$response, self::$response['meta']['code']);
  }

  public static function error($data = null, $message = null, $code = 400)
  {
    self::$response['meta']['status'] = 'error';
    self::$response['meta']['code'] = $code;
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;

    return response()->json(self::$response, self::$response['meta']['code']);
  }

}