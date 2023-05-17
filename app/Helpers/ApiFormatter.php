<?php 
namespace App\Helpers;

class ApiFormatter {
    // kalau langsung $ artinya property contoh nya $respon
    protected static $response = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
    ];

    // yang ada function itu method
    public static function createAPI($code = NULL, $message = NULL, $data = NULL){
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        // mengebalikan data kemabli dengan json 
        return response()->json(self::$response, self::$response['code']);
    }
}
?>  