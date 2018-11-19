<?php

use Illuminate\Http\Request;
use App\Http\Requests\CheckStatusRequest;

Route::get('feeds/parse', 'FeedController@parse');
Route::get('feeds/export', 'FeedController@export');
Route::resource('feeds', 'FeedController');

Route::post('check-status', function (CheckStatusRequest $request)
{
    Artisan::call('feeds:check_all_status');
});