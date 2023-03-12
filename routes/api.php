<?php

use App\Http\Controllers\ProductapiController;
use App\Http\Controllers\UsersapiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users/{id?}', [UsersapiController::class, 'showapi']);


Route::get('/myuser/{id?}', [UsersapiController::class, 'alluser']);


//all user list api 
Route::get('/alluser/{id?}', [UsersapiController::class, 'userlist']);




//add post  user api 
Route::post('/add/user', [UsersapiController::class, 'add_user']);


//update post  user api 
Route::put('/update_user/{id}', [UsersapiController::class, 'update_user']);




//single update post  user api 
Route::patch('/update_single_user/{id}', [UsersapiController::class, 'update_user_single']);


//single delete post  user api 
Route::delete('/delete_single_user/{id}', [UsersapiController::class, 'delete_user_single']);


//single delete post  user api with json
Route::delete('/delete_single_userwithjson', [UsersapiController::class, 'delete_user_singlejson']);





//multiple  delete post  user api with json
Route::delete('/delete_multi_user/{ids}', [UsersapiController::class, 'delete_user_multi']);

//multiple  delete post  user api with json
Route::delete('/delete_multi_userwithjson', [UsersapiController::class, 'delete_user_multijson']);





//add post  multiple user api 
Route::post('/add/user_multiple', [UsersapiController::class, 'add_usermultiple']);


//All Product Show get Api
Route::get('/allproduct/{id?}', [ProductapiController::class, 'allproduct']);


//add Product  post Api
Route::post('/add/product', [ProductapiController::class, 'add_product']);



//add multile Product  post Api
Route::post('/add/product_multiple', [ProductapiController::class, 'add_productmultiple']);
