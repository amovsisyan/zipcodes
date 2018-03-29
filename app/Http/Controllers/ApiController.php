<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ResponseController;

class ApiController extends Controller
{
    public function __construct()
    {
    }

    protected static $API_URL = 'http://api.zippopotam.us/';

    /**
     * Call API URL and returns expected response
     * @param $request
     * @param $country
     * @return array
     */
    public static function apiGetPlaces($request, $country)
    {
        try {
            $url = self::getAPI_URL($request, $country);
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url);

            if ($res->getStatusCode() === 200) {
                $crawledPlaces = [];
                $content = json_decode($res->getBody()->getContents(), true);

                foreach ($content['places'] as $place) {
                    $crawledPlaces['places'][] = self::_makePlacesFromCrawl($place);
                }

                $crawledPlaces['additional'] = self::_makePlacesAdditionalFromCrawl($content);

                return ResponseController::_standardResponseAPI($crawledPlaces);
            }
        } catch (\Exception $e) {
            return ResponseController::_catchedResponseAPI($e);
        }
    }


    /**
     * Simple getter for URL
     * @return string
     */
    public static function getURL()
    {
        return self::$API_URL;
    }

    /**
     * Creates and returns needed URL
     * @param $request
     * @param $country
     * @return string
     */
    protected static function getAPI_URL($request, $country)
    {
        return self::getURL() . strtoupper($country->abbr) . '/' . $request->post_code;
    }

    /**
     * Standard maker for places
     * @param $place
     * @return array
     */
    protected static function _makePlacesFromCrawl($place)
    {
        return [
            'placeName'   => $place['place name']
            , 'placeLong' => $place['longitude']
            , 'placeLat'  => $place['latitude']
        ];
    }

    /**
     * Standard maker for place additional info
     * @param $content
     * @return array
     */
    protected static function _makePlacesAdditionalFromCrawl($content)
    {
        return [
            'postcode'      => $content['post code']
            , 'stateName'   => $content['places'][0]['state']
            , 'stateAbbr'   => $content['places'][0]['state abbreviation']
            , 'CountryName' => $content['country']
            , 'CountryAbbr' => $content['country abbreviation']
        ];
    }
}
