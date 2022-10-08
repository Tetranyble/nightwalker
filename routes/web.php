<?php

use Instagram\Api;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Illuminate\Support\Facades\Route;
use Phpfastcache\Helper\Psr16Adapter;

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
    $profile = $api->getProfile($request->name);

    //echo $profile->getUserName(); // robertdowneyjr

    //return $profile->getFullName(); // Robert Downey Jr. Official

    sleep(1);
    $feedStories = $api->getStories($profile->getId());

    $stories = $feedStories->getStories();

    dd($stories);

});

Route::get('instagram/auth', function(\Illuminate\Http\Request $request){


    $instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'invisiblenightwalker', 'ugbanawaji1234A', new Psr16Adapter('Files'));
    $instagram->login(); // will use cached session if you want to force login $instagram->login(true)
    $instagram->saveSession();  //DO NOT forget this in order to save the session, otherwise have no sense
    $account = $instagram->getMedias($request->name);
    dd($account);

});
Route::get('instagram/users', function(\Illuminate\Http\Request $request){

    // https://docs.guzzlephp.org/en/stable/request-options.html#proxy
    //$instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client(['proxy' => 'tcp://localhost:8125']));
    // Request with proxy
    $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
    $nonPrivateAccountMedias = $instagram->getMedias($request->name);
    dd($nonPrivateAccountMedias[0]->getLink());

});
