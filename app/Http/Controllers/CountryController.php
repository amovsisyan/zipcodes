<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Response\ResponseController;

class CountryController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Returns all countries from DB
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getCountries()
    {
        $response = [];
        $countries = Country::select('id', 'name', 'abbr')
            ->orderBy('name')
            ->get();

        $response['countries'] = self::preparegetCountriesResponse($countries);

        return response()
            -> view('welcome', ['response' => $response]);
    }

    /**
     * Prepare response for getCountries() method
     * @param $countries
     * @return array
     */
    protected static function preparegetCountriesResponse($countries)
    {
        $response = [];

        if (empty($countries)) {
            $response[] = [
                'id'   => null
                , 'name' => null
                , 'abrr' => null
            ];
        } else {
            foreach ($countries as $country) {
                $response[] = [
                    'id'   => $country->id
                    , 'name' => $country->name
                    , 'abbr' => $country->abbr
                ];
            }
        }

        return $response;
    }
}
