<?php

namespace App\Http\Controllers\Response;

use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    public static function _validationResultResponse($validationResult) {
        return response(
            [
                'error'    => true,
                'type'     => $validationResult['type'],
                'response' => $validationResult['response']
            ], 404
        );
    }

    public static function _catchedResponse(\Exception $e) {
        return response(
            [
                'error'    => true,
                'type'     => '',
                'response' => [$e->getMessage()]
            ], 404
        );
    }

    public static function _catchedResponseAPI(\Exception $e) {
        return [
            'error'    => true,
            'type'     => '',
            'response' => [$e->getMessage()]
        ];
    }

    public static function _standardResponse($response) {
        return response(
            [
                'error'    => false,
                'type'     => '',
                'response' => $response
            ], 200
        );
    }

    public static function _standardResponseAPI($response) {
        return [
            'error'    => false,
            'type'     => '',
            'response' => $response
        ];
    }
}
