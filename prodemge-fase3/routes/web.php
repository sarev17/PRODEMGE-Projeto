<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Home');
});

Route::prefix('usuario')->group(function(){
    Route::get('cadastro',function(){
        return Inertia::render('Register');
    });
    Route::get('editar/{user}',function($user){
        $user = User::find($user);
        if($user){
            $user->document = $user->people->document;
            $user->contact = $user->people->contacts->first()->phone_number;
            $user->father_name = $user->people->father_name;
            $user->mother_name = $user->people->mother_name;
            $user->address = $user->people->address;
        }
        return Inertia::render('Edit',[
            'user'=>$user
        ]);
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
