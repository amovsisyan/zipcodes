<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Response\ResponseController;
use Goutte\Client;

class CrawlController extends Controller
{
    public $update = [];

    /**
     * Crawl and get All Countries from needed page
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function crawlCountries()
    {
        try {
            $this->grabCountries();
        } catch (\Exception $e) {
            return ResponseController::_catchedResponse($e);
        }

        return ResponseController::_standardResponse('Countries added (updated).');
    }

    /**
     * Main grab logic for crawlCountries()
     */
    protected function grabCountries()
    {
        $client = new Client();
        $crawler = $client->request('GET', ApiController::getURL());

        $crawler->filter('.table-condensed tbody tr')->each(function ($node) {
            $countryName = $node->filter('td:nth-child(1)')->html();
            $countryAbbr = $node->filter('td:nth-child(2)')->html();
            $update = [
                'name' => $countryName,
                'abbr' => $countryAbbr
            ];
            Country::firstOrCreate($update);
        });
    }
}
