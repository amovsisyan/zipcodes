<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Response\ResponseController;
use App\Http\Controllers\Validation\ValidationController;
use App\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Main managing method for checking whether get from DB or Crawl and get from Crawled
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getPlaces(Request $request)
    {
        $validationResult = ValidationController::validateGetPlaces($request->all());

        if ($validationResult['error']) {
            return ResponseController::_validationResultResponse($validationResult);
        }

        $country = Country::findOrFail($request->countryId);
        $placesForResponse = self::getPlacesFromDB($request, $country);

        try {
            if (empty($placesForResponse)) {
                $crawledResponse = ApiController::apiGetPlaces($request, $country);

                if ($crawledResponse && !$crawledResponse['error']) {
                    $placesForResponse = $crawledResponse['response'];
                    self::proceedNewPlaceCreation($placesForResponse);
                } else {
                    throw new \Exception('Sorry there is no places for this post code. Please check country or(and) post code');
                }
            };
        } catch (\Exception $e) {
            return ResponseController::_catchedResponse($e);
        }

        return ResponseController::_standardResponse($placesForResponse);
    }

    /**
     * Get places from DB and returns empty array if there is no result
     * @param $request
     * @param $country
     * @return array
     */
    protected static function getPlacesFromDB($request, $country)
    {
        $placesFromDB = [];
        if ($country && count($country)) {
            $postcode = $country->postCodes()->where('post_code', $request->post_code)->first();
            if ($postcode && count($postcode)) {
                $places = $postcode->places()->with(
                    [
                        'State',
                        'PostCode'
                    ]
                )->get();
                if ($places && count($places)) {
                    foreach ($places as $place) {
                        $placesFromDB['places'][] = self::_makePlacesFromDB($place);
                    }

                    $placesFromDB['additional'] = self::_makePlacesAdditionalFromDB($places[0], $country);
                }
            }
        }
        return $placesFromDB;
    }

    /**
     * Process method of adding new places and its additional info to DB after crawl Succeed
     * @param $placesForResponse
     */
    protected static function proceedNewPlaceCreation($placesForResponse)
    {
        $country = Country::firstOrCreate(self::_makeCountryInsert($placesForResponse));

        $newState = $country->states()->firstOrCreate(self::_makeStateInsert($placesForResponse, $country));

        $newPostCode = $country->postCodes()->firstOrCreate(self::_makePostCodeInsert($placesForResponse, $country));

        $placeInsertArr = [];

        foreach ($placesForResponse['places'] as $place) {
            $placeInsertArr[] = self::_makePlaceInsert($place, $newState);
        }

        $newPostCode->places()->createMany($placeInsertArr);
    }

    /**
     * Simple from standard maker for places from DB
     * @param $place
     * @return array
     */
    protected static function _makePlacesFromDB($place)
    {
        return [
            'placeName'   => $place['name']
            , 'placeLong' => $place['long']
            , 'placeLat'  => $place['lat']
        ];
    }

    /**
     * Simple from standard maker for places additional from DB
     * @param $placeStatePostCode
     * @param $placeCountry
     * @return array
     */
    protected static function _makePlacesAdditionalFromDB($placeStatePostCode, $placeCountry)
    {
        return [
            'postcode'      => $placeStatePostCode['PostCode']['post_code']
            , 'stateName'   => $placeStatePostCode['State']['name']
            , 'stateAbbr'   => $placeStatePostCode['State']['abbr']
            , 'CountryName' => $placeCountry['name']
            , 'CountryAbbr' => $placeCountry['abbr']
        ];
    }

    /**
     * Simple from standard maker for inserting Country
     * @param $placesForResponse
     * @return array
     */
    private static function _makeCountryInsert($placesForResponse)
    {
        return [
            'abbr'   => $placesForResponse['additional']['CountryAbbr']
            , 'name' => $placesForResponse['additional']['CountryName']
        ];
    }

    /**
     * Simple from standard maker for inserting State
     * @param $placesForResponse
     * @param $country
     * @return array
     */
    private static function _makeStateInsert($placesForResponse, $country)
    {
        return [
            'name'         => $placesForResponse['additional']['stateName']
            , 'abbr'       => $placesForResponse['additional']['stateAbbr']
            , 'country_id' => $country->id
        ];
    }

    /**
     * Simple from standard maker for inserting PostCode
     * @param $placesForResponse
     * @param $country
     * @return array
     */
    private static function _makePostCodeInsert($placesForResponse, $country)
    {
        return [
            'post_code'    => $placesForResponse['additional']['postcode']
            , 'country_id' => $country->id
        ];
    }

    /**
     * Simple from standard maker for inserting Place
     * @param $place
     * @param $newState
     * @return array
     */
    private static function _makePlaceInsert($place, $newState)
    {
        return [
            'name'       => $place['placeName']
            , 'long'     => $place['placeLong']
            , 'lat'      => $place['placeLat']
            , 'state_id' => $newState->id
        ];
    }

    public function redirect()
    {
        return redirect()->route('getCountries');
    }
}
