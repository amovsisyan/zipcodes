<?php

Route::get('/', ['uses'=>'CountryController@getCountries','as'=>'getCountries']);

Route::post('/getPlaces', ['uses'=>'PlaceController@getPlaces','as'=>'getPlaces']);

Route::get('/crawlCountries', ['uses'=>'CrawlController@crawlCountries','as'=>'crawlCountries']);

Route::any('{catchall}', ['uses'=>'PlaceController@redirect','as'=>'redirect'])->where('catchall', '(.*)');



