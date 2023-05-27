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

    Route::get('/test', function () {
        return view('test');
    });

    //Dashboard
    Route::get('/dashboard', function () { //override default jetstream dashboard to pantar's one
        return redirect('/app');
    })->name('dashboard');

    Route::get('/app', App::class);

    //Api controller
    Route::controller(ApiController::class)->group(function () {
        Route::prefix('api')->group(function () {
            Route::get('/test', 'test');
            Route::get('/recipes', 'getRecipes')->name('api.recipesQuery')
                ->withoutMiddleware(VerifyCsrfToken::class)
                ->withoutMiddleware('auth');
            Route::post('/recipeinformation/{recipeId}', 'addRecipeInformationToLocalDB')
               ->withoutMiddleware(VerifyCsrfToken::class)
               ->withoutMiddleware('auth');
            Route::get('/recipesingredients', 'getRecipesByIngredients')
               ->withoutMiddleware(VerifyCsrfToken::class)
               ->withoutMiddleware('auth');
            Route::get('/ingredients', 'getIngredients')->name('api.ingredientsQuery');
            Route::get('/useringredients', 'getUserIngredients')->name('api.userIngredients');
            Route::post('/conversion', 'addConversionToGrams')
                ->withoutMiddleware(VerifyCsrfToken::class)
                ->withoutMiddleware('auth');
        });
    });
});
