<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VariantPropController;
use App\Http\Controllers\VariantTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    
});


Route::group(['prefix' => 'product'], function ($router) {
    
    Route::post('getproduct', [ProductController::class, 'getSingleProduct']);
    Route::get('getall', [ProductController::class, 'index']);
    Route::post('create', [ProductController::class, 'create']);
    Route::post('update', [ProductController::class, 'update']);
    Route::post('delete', [ProductController::class, 'deletePoduct']);
});
Route::group(['prefix' => 'variant'], function ($router) {
    Route::post('create', [VariantPropController::class, 'create']);
    Route::post('delete', [VariantPropController::class, 'destroy']);
    Route::post('createtype', [VariantTypeController::class, 'create']);
    Route::post('update', [VariantTypeController::class, 'update']);
    Route::get('all', [VariantTypeController::class, 'getAllVariant']);
});
Route::group(['prefix' => 'category'], function ($router) {
    Route::post('create', [CategoryController::class, 'create']);
    Route::post('delete', [CategoryController::class, 'destroy']);
    Route::post('update', [CategoryController::class, 'update']);
    Route::post('all', [CategoryController::class, 'getAllCategories']);
});
Route::group(['prefix' => 'wishlist'], function ($router) {
    Route::post('create', [WishlistController::class, 'create']);
    Route::post('delete', [WishlistController::class, 'destroy']);
    Route::post('update', [WishlistController::class, 'update']);
    Route::post('getwishlists', [WishlistController::class, 'index']);
});
Route::group(['prefix' => 'comment'], function ($router) {
    Route::post('create', [CommentController::class, 'create']);
    Route::post('delete', [CommentController::class, 'destroy']);
    Route::post('update', [CommentController::class, 'update']);
    // Route::post('getwishlists', [CommentController::class, 'index']);
});
Route::group(['prefix' => 'options'], function ($router) {
    Route::post('homepage', [OptionsController::class, 'updateHomeOptions']);
});
Route::get('/get-product-image/{filename}', [ImageController::class, 'getProductImage']);