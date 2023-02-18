<?php

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

Route::get('/load-episodes', function () {
    //Create a route /episodes  in web.php and inside the route function:
//Read a showNumber query string variable and if not set then default it to 1
//You'll interpolate the number into the api call to determine which show's episodes to display

    //Make sure showNumber is set and if not set it to 1
    $showNumber = intval(request('showNumber'));
    //Make sure showNumber is an integer and if not set it to 1
    $showNumber = $showNumber <= 0 ? 1 : $showNumber;

    $episodes = App\Models\TvMazeAPI::fetch($showNumber);
    return view('episodes', [
        'episodes' => $episodes,
    ]);
});

Route::get('/view-episodes', function () {
    $showNumber = intval(request('showNumber'));
    $showNumber = $showNumber <= 0 ? 1 : $showNumber;
    $episodes = App\Models\Episode::where('show_number', $showNumber)->get();
    return view('episodes', [
        'episodes' => $episodes,
    ]);
});