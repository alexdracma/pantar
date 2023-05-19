<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\App;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\VerifyCsrfToken;

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
    Route::get('/dashboard', function () { //override default jetstream dashboard to pantar's one
        return redirect('/app');
    })->name('dashboard');

    Route::get('/app', App::class);

    //Api controller
    Route::controller(ApiController::class)->group(function () {
        Route::prefix('api')->group(function () {
           Route::get('/recipes', 'getRecipes')->name('api.recipesQuery');
           Route::get('/ingredients', 'getIngredients')->name('api.ingredientsQuery');
           Route::post('/conversion', 'addConversionToGrams')
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->withoutMiddleware('auth');
        });
    });
});
