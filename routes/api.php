<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryCotroller;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Models\Banner;
use App\Models\Delivery;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


/*|--------------------------------------------------------------------------|
  | Users Route                                                              |
  |--------------------------------------------------------------------------|*/


Route::post('register',[UsersController::class,'addUserDetails'])->middleware('checkHeader');
Route::post('firebaseRegister',[UsersController::class,'firebaseRegister'])->middleware('checkHeader');
Route::post('updateProfile',[UsersController::class,'updateProfile'])->middleware('checkHeader')->middleware('checkToken');
Route::post('getProfile',[UsersController::class,'getProfile'])->middleware('checkHeader')->middleware('checkToken');
Route::post('getAllDeliveryAddress',[AddressController::class,'getAllDeliveryAddress'])->middleware('checkHeader')->middleware('checkToken');
Route::post('addAddress',[AddressController::class,'addAddress'])->middleware('checkHeader')->middleware('checkToken');
Route::post('getAddressDateile',[AddressController::class,'getAddressDateile'])->middleware('checkHeader')->middleware('checkToken');
Route::post('updateAddress',[AddressController::class,'updateAddress'])->middleware('checkHeader')->middleware('checkToken');
Route::post('deleteAddress',[AddressController::class,'deleteAddress'])->middleware('checkHeader')->middleware('checkToken');
Route::post('logout',[UsersController::class,'logout'])->middleware('checkHeader')->middleware('checkToken');
Route::post('getDefaultDeliveryAddress',[AddressController::class,'getDefaultDeliveryAddress'])->middleware('checkHeader')->middleware('checkToken');


/*|--------------------------------------------------------------------------|
  | Setting  Route                                                           |
  |--------------------------------------------------------------------------|*/

Route::post('getBannerList',[BannerController::class,'getBannerList'])->middleware('checkHeader');
Route::post('getFaqList',[FaqController::class,'getFaqList'])->middleware('checkHeader');
Route::post('getWebFaqList',[FaqController::class,'getWebFaqList'])->middleware('checkHeader');
Route::post('getAddressList',[CityController::class,'getAddressList'])->middleware('checkHeader');
Route::post('getAreaByCity',[CityController::class,'getAreaByCity'])->middleware('checkHeader');
Route::post('getCityList',[CityController::class,'getCityList'])->middleware('checkHeader');
Route::post('getAreaList',[AreaController::class,'getAreaList'])->middleware('checkHeader');
Route::post('getWebAeraList',[AreaController::class,'getWebAeraList'])->middleware('checkHeader');

/*|--------------------------------------------------------------------------|
  | Product  Route                                                           |
  |--------------------------------------------------------------------------|*/


Route::post('Product/getProductList',[ProductController::class,'getProductList'])->middleware('checkHeader');
Route::post('Product/getCategoryList',[ProductController::class,'getCategoryList'])->middleware('checkHeader');
Route::post('Product/homePage',[ProductController::class,'homePage'])->middleware('checkHeader');
Route::post('Product/getProductById',[ProductController::class,'getProductById'])->middleware('checkHeader');
Route::post('Product/searchProduct',[ProductController::class,'searchProduct'])->middleware('checkHeader');
Route::post('Product/searchProductByCategory',[ProductController::class,'searchProductByCategory'])->middleware('checkHeader');
Route::post('Product/getProductByCategoryId',[ProductController::class,'getProductByCategoryId'])->middleware('checkHeader');


Route::post('Product/addupdateToWishlist',[WishListController::class,'addupdateToWishlist'])->middleware('checkHeader')->middleware('checkToken');
Route::post('Product/getWishlist',[WishListController::class,'getWishlist'])->middleware('checkHeader')->middleware('checkToken');
Route::post('Product/removeProductFromWishlist',[WishListController::class,'removeProductFromWishlist'])->middleware('checkHeader')->middleware('checkToken');
Route::post('Product/getAllNotification',[NotificationController::class,'getAllNotification'])->middleware('checkHeader');
Route::post('Product/getAllUserNotification',[NotificationController::class,'getAllUserNotification'])->middleware('checkHeader')->middleware('checkToken');


/*|--------------------------------------------------------------------------|
  | Delivery Boy  Route                                                      |
  |--------------------------------------------------------------------------|*/

  Route::post('DeliveryBoy/register',[DeliveryController::class,'addUserDetails'])->middleware('checkHeader');
  Route::post('DeliveryBoy/logout',[DeliveryController::class,'logout'])->middleware('checkHeader')->middleware('checkTokenDb');

  Route::post('DeliveryBoy/updateProfile',[DeliveryController::class,'updateProfile'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/changeAvialableStatus',[DeliveryController::class,'changeAvialableStatus'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/getProfile',[DeliveryController::class,'getProfile'])->middleware('checkHeader')->middleware('checkTokenDb');

  Route::post('DeliveryBoy/getPendingOrders',[DeliveryController::class,'getPendingOrders'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/getCompletedOrders',[DeliveryController::class,'getCompletedOrders'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/getOrderDetails',[DeliveryController::class,'getOrderDetails'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/completeDelivery',[DeliveryController::class,'completeDelivery'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/onHoldDelivery',[DeliveryController::class,'onHoldDelivery'])->middleware('checkHeader')->middleware('checkTokenDb');
  Route::post('DeliveryBoy/startDelivery',[DeliveryController::class,'startDelivery'])->middleware('checkHeader')->middleware('checkTokenDb');



/*|--------------------------------------------------------------------------|
  | Order  Route                                                             |
  |--------------------------------------------------------------------------|*/

    Route::post('Order/getSettingData',[SettingController::class,'getShipingCharg'])->middleware('checkHeader');

    
  Route::post('Order/placeOrder',[OrderController::class,'placeOrder'])->middleware('checkHeader')->middleware('checkToken');

  Route::post('Order/checkProduct',[OrderController::class,'checkProduct'])->middleware('checkHeader')->middleware('checkToken');

  Route::post('Order/getCoupon',[OrderController::class,'getCoupon'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/getMyOrderList',[OrderController::class,'getMyOrderList'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/raiseComplaint',[ComplaintController::class,'raiseComplaint'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/getAllComplaint',[ComplaintController::class,'getAllComplaint'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/deleteComplaint',[ComplaintController::class,'deleteWebComplaint'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/getOrderDetailsById',[OrderController::class,'getOrderDetailsById'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/applyCoupan',[OrderController::class,'applyCoupan'])->middleware('checkHeader')->middleware('checkToken');
  Route::post('Order/productReviewRating',[ReviewController::class,'productReviewRating'])->middleware('checkHeader')->middleware('checkToken');

  Route::post('Order/getAllOrderRating',[ReviewController::class,'getAllOrderRating'])->middleware('checkHeader');
  Route::post('Order/getAllWebRating',[ReviewController::class,'getAllWebRating'])->middleware('checkHeader');
  Route::post('Order/cancelledOrder',[OrderController::class,'cancelledOrder'])->middleware('checkHeader')->middleware('checkToken');


 Route::post('onlineOrder', [OrderController::class, 'onlineOrder']);
  Route::post('onlinePlaceOrder', [OrderController::class, 'onlinePlaceOrder']);

