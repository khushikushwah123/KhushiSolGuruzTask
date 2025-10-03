<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//USer
Route::post('register',       [AuthController::class,'register']);
Route::post('login',          [AuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('logout',          [AuthController::class,'logout']);
    Route::post('profile',         [AuthController::class,'profile']);
    Route::post('product-list',    [AuthController::class,'product_list']);
    Route::post('add-cart',          [AuthController::class,'add_cart']);
    Route::post('remove-from-cart',  [AuthController::class,'remove_from_cart']);
    Route::post('my-cart',           [AuthController::class,'my_cart']);
    Route::post('place-order',       [AuthController::class,'place_order']);
});
