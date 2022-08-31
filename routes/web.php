<?php

use Instagram\Api;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('feeds', function(\Illuminate\Http\Request $request){


    $cachePool = new FilesystemAdapter('Instagram', 0, storage_path('framework/cache'));

    $api = new Api($cachePool);
    $api->login('invisiblenightwalker', 'ugbanawaji1234A'); // mandatory
    $profile = $api->getProfile('luchydonalds');

    //echo $profile->getUserName(); // robertdowneyjr

    //return $profile->getFullName(); // Robert Downey Jr. Official
    return $profile->getMedias();
});
