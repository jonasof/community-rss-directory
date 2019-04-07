<?php

use App\Http\Requests\CheckStatusRequest;

Route::get('feeds/parse', 'FeedController@parse');
Route::get('feeds/export', 'FeedController@export');
Route::get('feeds/{id}/download', 'FeedController@download');
Route::resource('feeds', 'FeedController');

Route::post('feeds/import/parse-file', 'FeedImportController@parse');

Route::post('check-status', function (CheckStatusRequest $request)
{
    Artisan::call('feeds:check_all_status');
});