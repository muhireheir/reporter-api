<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::any('/re-charge','StudentController@updatePayment');



Route::any('/re-charge-init','StudentController@initTransaction');




Route::middleware(['cors'])->group(function(){
    Route::post('/login','UserController@login');
    Route::post('/add_student_card','StudentController@addCard');
    Route::post('/charge','StudentController@charge');

});
