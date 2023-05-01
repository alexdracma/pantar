<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

//Authenticated
Route::middleware('auth')->group(function () {

    //Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/app', App::class);
});

Route::get('/test', function () {
    return \App\Models\Post::find(2)->recipe;
});

Route::get('/account', function () {
    return view('app.account');
});



//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified'
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');
//});
