<?php

use App\Http\Controllers\ApiController;
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


// Home Page
Route::get("recentlyAddedProducts",[ApiController::class,'recentlyAddedProducts']);
Route::get("mostViewedProducts",[ApiController::class,'mostViewedProducts']);
Route::get("featuredProducts",[ApiController::class,'featuredProducts']);

Route::get("allCategories",[ApiController::class,'allCategories']);
Route::get("productsByCategory/{cat_id}",[ApiController::class,'productsByCategory']);
Route::get("productsSaleByCategory/{cat_id}",[ApiController::class,'productsSaleByCategory']);

// Search Page
Route::get("search/{str}",[ApiController::class,'search']);

// Filter Page
Route::get("randomProducts",[ApiController::class,'randomProducts']);
Route::get("getColors",[ApiController::class,'getColors']);
Route::get("getSizes",[ApiController::class,'getSizes']);
Route::get("getPriceFilter",[ApiController::class,'getPriceFilter']);
Route::post("filteredProducts",[ApiController::class,'filteredProducts']);

// Product Page
Route::get("getProductColors/{id}",[ApiController::class,'getProductColors']);
Route::get("getProductSizes/{id}",[ApiController::class,'getProductSizes']);
Route::get("productById/{id}",[ApiController::class,'productById']);
Route::get("relatedProducts/{id}",[ApiController::class,'relatedProducts']);

// Auth Page
Route::post("login",[ApiController::class,'login']);
Route::post("register",[ApiController::class,'register']);



// for authorized urls
Route::group(['middleware' => ['auth:sanctum']], function (){
    

    


    //Profile Page
    Route::get("nameAndImage",[ApiController::class,'nameAndImage']);
    Route::get("myOrders",[ApiController::class,'myOrders']);
    Route::get("myProfile",[ApiController::class,'myProfile']);
    Route::post("updateMyProfile",[ApiController::class,'updateMyProfile']); // Not complete yet


    //Wishlist Page
    Route::get("myWishlist",[ApiController::class,'myWishlist']);
    Route::post("addToWishlist",[ApiController::class,'addToWishlist']);  // Not used yet
    Route::post("removeItemWishlist",[ApiController::class,'removeItemWishlist']);
    Route::post("moveToCart",[ApiController::class,'moveToCart']);
    Route::post("clearWishlist",[ApiController::class,'clearWishlist']);

    //Cart Page
    Route::get("myCart",[ApiController::class,'myCart']);
    Route::post("addToCart",[ApiController::class,'addToCart']);  // need to add product option
    Route::post("increaseItemCartQuantity",[ApiController::class,'increaseItemCartQuantity']);
    Route::post("decreaseItemCartQuantity",[ApiController::class,'decreaseItemCartQuantity']);
    Route::post("removeItemCart",[ApiController::class,'removeItemCart']);
    Route::post("clearCart",[ApiController::class,'clearCart']);
    Route::get("cartSummary",[ApiController::class,'cartSummary']);




    Route::get("logout",[ApiController::class,'logout']);
});



