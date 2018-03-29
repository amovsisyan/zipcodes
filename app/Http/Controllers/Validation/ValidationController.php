<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\DBColumnsLengthData;
use Validator;

class ValidationController extends AbstractValidator
{
    /**
     * Validate getPlaces Route
     * @param $allRequest
     * @return array
     */
    public static function validateGetPlaces($allRequest)
    {
        $rules = [
            'countryId' => 'required|min:1|max:10',
            'post_code' => 'required|min:1|max:' . DBColumnsLengthData::POST_CODES_TABLE['post_code']
        ];

        $validator = Validator::make($allRequest, $rules);

        if ($validator->fails()) {
            return self::_generateValidationErrorResponse($validator);
        };

        return self::_generateValidationSimpleOKResponse();
    }
}
