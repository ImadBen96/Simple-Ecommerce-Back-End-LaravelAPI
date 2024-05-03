<?php

use App\Http\Controllers\AuthController;
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
Route::middleware(['auth:sanctum'])->group(static function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::apiResources([
    'products' => \App\Http\Controllers\ProductController::class,
]);
Route::apiResources([
    'categories' => \App\Http\Controllers\CategoryController::class,
]);
Route::apiResources([
    'logo' => \App\Http\Controllers\LogoController::class,
]);
Route::apiResources([
    'shopCategory' => \App\Http\Controllers\ShopCategoryController::class,
]);

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});
// Cart
Route::post("add-to-cart",[\App\Http\Controllers\CartController::class,"addToCart"]);
Route::get("cart",[\App\Http\Controllers\CartController::class,"viewcart"]);
Route::put("cart-update-quantity/{cart_id}/{scope}",[\App\Http\Controllers\CartController::class,"updateQty"]);
Route::delete("delete-cart-item/{cart_id}",[\App\Http\Controllers\CartController::class,"deleteCartItem"]);

require __DIR__.'/auth.php';

//    Route::post('login', [AuthController::class, 'login']);
//    Route::post('register', [AuthController::class, 'register']);
//
//    Route::group(['middleware' => 'auth:sanctum'], function() {
//        Route::get('logout', [AuthController::class, 'logout']);
//        Route::get('user', [AuthController::class, 'user']);
//    });
//payment Process
Route::group(["prefix" => "payment"],function () {
   Route::post("/",[\App\Http\Controllers\PaymentController::class,"makePayment"]);
});
Route::group(["prefix" => "dashboard"],function () {
   Route::get("/",[\App\Http\Controllers\DashboardController::class,"index"]);
   Route::get("/customers",[\App\Http\Controllers\DashboardController::class,"allCustomers"]);
   Route::get("/orders",[\App\Http\Controllers\DashboardController::class,"allOrders"]);
});

//require __DIR__.'/auth.php';
