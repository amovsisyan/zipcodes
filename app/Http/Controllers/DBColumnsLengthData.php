<?php

namespace App\Http\Controllers;

/**
 * This Controller is settings package for DB columns length
 * It is used both in migration and validation
 * For future this could include also DB columns standardization
 * Class DBColumnsLengthData
 * @package App\Http\Controllers
 */

class DBColumnsLengthData extends Controller
{
    const COUNTRIES_TABLE = [
        'name' => 50,
        'abbr' => 4
    ];

    const STATES_TABLE = [
        'name' => 80,
        'abbr' => 4
    ];

    const POST_CODES_TABLE = [
        'post_code' => 10
    ];

    const PLACES_TABLE = [
        'name' => 80,
        'long' => [
            'digits' => 11,
            'after' => 8
        ],
        'lat' => [
            'digits' => 10,
            'after' => 8
        ],
    ];
}
