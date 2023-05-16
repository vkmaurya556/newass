<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users;
use App\Http\Controllers\Business;
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

Route::get('/user', function (Request $request) {
    // return $request->user();
    return "SD";
});


Route::post("/addbusiness", [Business::class, 'create']);
Route::post("/businesslist", [Business::class, 'list']);
Route::post("/userlogin", [Users::class, 'login']);
Route::post("/usersignup", [Users::class, 'signup']);
Route::post("/userrating", [Users::class, 'rating']);
