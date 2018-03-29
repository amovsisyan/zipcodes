<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;

class AbstractValidator extends Controller
{
    /**
     * Standard Validation error for Project
     * @param $validator
     * @return array
     */
    protected static function _generateValidationErrorResponse($validator)
    {
        $errors = $validator->errors();
        $response = [];
        foreach ($errors->all() as $message) {
            $response[] = $message;
        }
        return [
            'error'    => true,
            'type'     => 'Validation Error',
            'response' => $response
        ];
    }

    protected static function _generateValidationSimpleOKResponse()
    {
        return [
            'error' => false,
        ];
    }
}
