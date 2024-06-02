<?php

use App\Http\Controllers\PeopleController;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('search')->group(function(){
    Route::get('{term}',[PeopleController::class,'search'])->name('search.people.name');
});

Route::prefix('user')->group(function(){
    Route::post('store',[PeopleController::class,'store']);
    Route::post('edit/{user}',[PeopleController::class,'edit']);
});
