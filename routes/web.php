<?php

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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UsersController;


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

Route::get('/',[LoginController::class,'login']);
Route::view('index', 'home.index')->middleware(['checkLogin'])->name('index');


Route::post('login',[LoginController::class,'checklogin'])->middleware(['checkLogin'])->name('login');
Route::post('updateProflie',[LoginController::class,'updateProflie'])->middleware(['checkLogin'])->name('updateProflie');

Route::get('logout',[LoginController::class,'logout'])->middleware(['checkLogin'])->name('logout');

/*|--------------------------------------------------------------------------|
  | Category Route                                                           |
  |--------------------------------------------------------------------------|*/

  Route::view('categories','category.category')->middleware(['checkLogin'])->name('categories');
  Route::get('category', [CategoryCotroller::class,'getcategory'])->middleware(['checkLogin'])->name('category');

  Route::get('deletecat/{cat_id}', [CategoryCotroller::class,'deleteCat'])->name('deleteCat')->middleware(['checkLogin']);
  Route::get('viewProductByCat/{id}', [CategoryCotroller::class,'viewProductByCat'])->name('viewProductByCat')->middleware(['checkLogin']);
  Route::post('addcat', [CategoryCotroller::class,'addCat'])->middleware(['checkLogin'])->name('addcat');
  Route::post('fetchAllCategory', [CategoryCotroller::class,'fetchAllCategory'])->middleware(['checkLogin'])->name('fetchAllCategory');
  Route::post('updatecat', [CategoryCotroller::class,'updateCat'])->middleware(['checkLogin'])->name('updatecat');

  Route::post('fetchAllCatProduct', [CategoryCotroller::class,'fetchAllCatProduct'])->middleware(['checkLogin'])->name('fetchAllCatProduct');
  Route::post('fetchAllOfsCatProduct', [CategoryCotroller::class,'fetchAllOfsCatProduct'])->middleware(['checkLogin'])->name('fetchAllOfsCatProduct');

/*|--------------------------------------------------------------------------|
  | Unit Route                                                               |
  |--------------------------------------------------------------------------|*/

  Route::view('unit','unit.unit')->middleware(['checkLogin'])->name('units');
  Route::get('getunit', [UnitController::class,'getUnit'])->middleware(['checkLogin'])->name('getunit');
  Route::post('fetchAllUnits', [UnitController::class,'fetchAllUnits'])->middleware(['checkLogin'])->name('fetchAllUnits');
  Route::post('addUnit', [UnitController::class,'addUnit'])->middleware(['checkLogin'])->name('addUnit');
  Route::post('updateUnit', [UnitController::class,'updateUnit'])->middleware(['checkLogin'])->name('updateUnit');
  Route::get('deleteUnit/{id}', [UnitController::class,'deleteUnit'])->name('deleteUnit')->middleware(['checkLogin']);


/*|--------------------------------------------------------------------------|
  | product Rout                                                             |
  |--------------------------------------------------------------------------|*/

  Route::view('product','product.product')->middleware(['checkLogin'])->name('product');
  Route::view('addProduct','product.addproduct')->middleware(['checkLogin'])->name('addProduct');
  Route::post('addProductindb', [ProductController::class,'addProductindb'])->middleware(['checkLogin'])->name('addProductindb');
  Route::post('fetchAllProduct', [ProductController::class,'fetchAllProduct'])->middleware(['checkLogin'])->name('fetchAllProduct');
  Route::post('fetchAllOfsProduct', [ProductController::class,'fetchAllOfsProduct'])->middleware(['checkLogin'])->name('fetchAllOfsProduct');
  Route::post('updateStock', [ProductController::class,'updateStock'])->middleware(['checkLogin'])->name('updateStock');

  Route::get('viewProduct/{id}', [ProductController::class,'viewProductByID'])->middleware(['checkLogin'])->name('viewProduct');
  Route::get('editProduct/{id}', [ProductController::class,'editProduct'])->middleware(['checkLogin'])->name('editProduct');

  Route::post('addImages', [ProductController::class,'addImages'])->middleware(['checkLogin'])->name('addImages');

  Route::get('removeImage/{id}', [ProductController::class,'removeImage'])->middleware(['checkLogin'])->name('removeImage');
  Route::get('removePrice/{id}', [ProductController::class,'removePrice'])->middleware(['checkLogin'])->name('removePrice');
  Route::get('deleteProduct/{id}', [ProductController::class,'deleteProduct'])->middleware(['checkLogin'])->name('deleteProduct');

  Route::post('addprice', [ProductController::class,'addprice'])->middleware(['checkLogin'])->name('addprice');

  Route::post('updateProduct', [ProductController::class,'updateProduct'])->middleware(['checkLogin'])->name('updateProduct');


/*|--------------------------------------------------------------------------|
  | Coupon Route                                                               |
  |--------------------------------------------------------------------------|*/

  Route::view('coupons','coupon.coupon')->middleware(['checkLogin'])->name('coupons');
  Route::get('getCoupanbyid/{id}', [CouponController::class,'getCoupanbyid'])->middleware(['checkLogin'])->name('getCoupanbyid');
  Route::post('fetchAllCoupon', [CouponController::class,'fetchAllCoupon'])->middleware(['checkLogin'])->name('fetchAllCoupon');
  Route::post('addCoupon', [CouponController::class,'addCoupon'])->middleware(['checkLogin'])->name('addCoupon');
  Route::post('updateCoupon', [CouponController::class,'updateCoupon'])->middleware(['checkLogin'])->name('updateCoupon');
  Route::get('deleteCoupan/{id}', [CouponController::class,'deleteCoupan'])->name('deleteCoupan')->middleware(['checkLogin']);

/*|--------------------------------------------------------------------------|
  | Banner Route                                                               |
  |--------------------------------------------------------------------------|*/

  Route::view('banner','banner.banner')->middleware(['checkLogin'])->name('banners');

  Route::post('fetchAllBanner', [BannerController::class,'fetchAllBanner'])->middleware(['checkLogin'])->name('fetchAllBanner');
  Route::post('addBanner', [BannerController::class,'addBanner'])->middleware(['checkLogin'])->name('addBanner');
  Route::post('updateBanner', [BannerController::class,'updateBanner'])->middleware(['checkLogin'])->name('updateBanner');
  Route::get('deleteBanner/{id}', [BannerController::class,'deleteBanner'])->name('deleteBanner')->middleware(['checkLogin']);

/*|--------------------------------------------------------------------------|
  | Faq Route                                                                |
  |--------------------------------------------------------------------------|*/

  Route::view('faq','faq.faq')->middleware(['checkLogin'])->name('faqs');
  Route::get('getFaqid/{id}', [FaqController::class,'getFaqid'])->middleware(['checkLogin'])->name('getFaqid');
  Route::post('fetchAllFaq', [FaqController::class,'fetchAllFaq'])->middleware(['checkLogin'])->name('fetchAllFaq');
  Route::post('addfaq', [FaqController::class,'addfaq'])->middleware(['checkLogin'])->name('addfaq');
  Route::post('updateFaq', [FaqController::class,'updateFaq'])->middleware(['checkLogin'])->name('updateFaq');
  Route::get('deleteFaq/{id}', [FaqController::class,'deleteFaq'])->name('deleteFaq')->middleware(['checkLogin']);

/*|--------------------------------------------------------------------------|
  | City Route                                                               |
  |--------------------------------------------------------------------------|*/

  Route::view('address','address.address')->middleware(['checkLogin'])->name('address');
  Route::get('getCity', [CityController::class,'getCity'])->middleware(['checkLogin'])->name('getCity');
  Route::post('fetchAllCity', [CityController::class,'fetchAllCity'])->middleware(['checkLogin'])->name('fetchAllCity');
  Route::post('addCity', [CityController::class,'addCity'])->middleware(['checkLogin'])->name('addCity');
  Route::post('updateCity', [CityController::class,'updateCity'])->middleware(['checkLogin'])->name('updateCity');
  Route::get('deleteCity/{id}', [CityController::class,'deleteCity'])->name('deleteCity')->middleware(['checkLogin']);


/*|--------------------------------------------------------------------------|
  | Area Route                                                               |
  |--------------------------------------------------------------------------|*/

  Route::post('fetchAllArea', [AreaController::class,'fetchAllArea'])->middleware(['checkLogin'])->name('fetchAllArea');
  Route::post('addArea', [AreaController::class,'addArea'])->middleware(['checkLogin'])->name('addArea');
  Route::post('updateArea', [AreaController::class,'updateArea'])->middleware(['checkLogin'])->name('updateArea');
  Route::get('deleteArea/{id}', [AreaController::class,'deleteArea'])->name('deleteArea')->middleware(['checkLogin']);


/*|--------------------------------------------------------------------------|
  | notification Route                                                       |
  |--------------------------------------------------------------------------|*/

  Route::view('notification','notification.notification')->middleware(['checkLogin'])->name('notification');
  Route::get('getNotiById/{id}', [NotificationController::class,'getNotiById'])->middleware(['checkLogin'])->name('getNotiById');

  Route::get('deleteNoti/{id}', [NotificationController::class,'deleteNoti'])->name('deleteNoti')->middleware(['checkLogin']);
  Route::post('addNotification', [NotificationController::class,'addNotification'])->middleware(['checkLogin'])->name('addNotification');
  Route::post('fetchAllNoti', [NotificationController::class,'fetchAllNoti'])->middleware(['checkLogin'])->name('fetchAllNoti');
  Route::post('updateNoti', [NotificationController::class,'updateNoti'])->middleware(['checkLogin'])->name('updateNoti');


/*|--------------------------------------------------------------------------|
  | setting Route                                                       |
  |--------------------------------------------------------------------------|*/

  Route::get('setting', [SettingController::class,'setting'])->middleware(['checkLogin'])->name('setting');
  Route::post('updateCharg', [SettingController::class,'updateCharg'])->middleware(['checkLogin'])->name('updateCharg');
  Route::post('updateIds', [SettingController::class,'updateIds'])->middleware(['checkLogin'])->name('updateIds');



  
/*|--------------------------------------------------------------------------|
  | Delivery Boy Rout                                                        |
  |--------------------------------------------------------------------------|*/

  Route::get('getDelivryBoy', [DeliveryController::class,'getDelivryBoy'])->middleware(['checkLogin'])->name('getDelivryBoy');

  Route::view('deliveryBoy','deliveryboy.deliveryboy')->middleware(['checkLogin'])->name('deliveryBoy');
  Route::post('fetchAllDbList', [DeliveryController::class,'fetchAllDbList'])->middleware(['checkLogin'])->name('fetchAllDbList');
  Route::post('addDeliveryBoy', [DeliveryController::class,'addDeliveryBoy'])->middleware(['checkLogin'])->name('addDeliveryBoy');
  Route::post('editDeliveryBoy', [DeliveryController::class,'editDeliveryBoy'])->middleware(['checkLogin'])->name('editDeliveryBoy');

  Route::get('getDbById/{id}', [DeliveryController::class,'getDbById'])->middleware(['checkLogin'])->name('getDbById');

  Route::get('viewDbDetails/{id}', [DeliveryController::class,'viewDbDetails'])->middleware(['checkLogin'])->name('viewDbDetails');
  Route::get('updatePayment/{id}', [DeliveryController::class,'updatePayment'])->middleware(['checkLogin'])->name('updatePayment');

  
  Route::get('deleteDeliveryBoy/{id}', [DeliveryController::class,'deleteDeliveryBoy'])->name('deleteDeliveryBoy')->middleware(['checkLogin']);


  Route::post('fetchAllDeliveryBoyCompletedOrder', [DeliveryController::class,'fetchAllDeliveryBoyCompletedOrder'])->middleware(['checkLogin'])->name('fetchAllDeliveryBoyCompletedOrder');
  Route::post('fetchAllDeliveryBoyConfirmOrder', [DeliveryController::class,'fetchAllDeliveryBoyConfirmOrder'])->middleware(['checkLogin'])->name('fetchAllDeliveryBoyConfirmOrder');
  Route::post('fetchAllDeliveryBoyHoldOrder', [DeliveryController::class,'fetchAllDeliveryBoyHoldOrder'])->middleware(['checkLogin'])->name('fetchAllDeliveryBoyHoldOrder');
/*|--------------------------------------------------------------------------|
  | Users Route                                                              |
  |--------------------------------------------------------------------------|*/

  Route::view('users','setting.users')->middleware(['checkLogin'])->name('users');

  Route::post('fetchAllUsers', [UsersController::class,'fetchAllUsers'])->middleware(['checkLogin'])->name('fetchAllUsers');



/*|--------------------------------------------------------------------------|
  | orders Route                                                              |
  |--------------------------------------------------------------------------|*/


  
  Route::view('orders','order.order')->middleware(['checkLogin'])->name('orders');

  Route::post('fetchAllOrder', [OrderController::class,'fetchAllOrder'])->middleware(['checkLogin'])->name('fetchAllOrder');
  Route::post('fetchAllProcessingOrder', [OrderController::class,'fetchAllProcessingOrder'])->middleware(['checkLogin'])->name('fetchAllProcessingOrder');
  Route::post('fetchAllConfirmedOrder', [OrderController::class,'fetchAllConfirmedOrder'])->middleware(['checkLogin'])->name('fetchAllConfirmedOrder');
  Route::post('fetchAllHoldOrder', [OrderController::class,'fetchAllHoldOrder'])->middleware(['checkLogin'])->name('fetchAllHoldOrder');
  Route::post('fetchAllCompletedOrder', [OrderController::class,'fetchAllCompletedOrder'])->middleware(['checkLogin'])->name('fetchAllCompletedOrder');
  Route::post('fetchAllCancelledOrder', [OrderController::class,'fetchAllCancelledOrder'])->middleware(['checkLogin'])->name('fetchAllCancelledOrder');
  Route::get('viewOrder/{id}', [OrderController::class,'viewOrder'])->middleware(['checkLogin'])->name('viewOrder');
  Route::get('deleteOrder/{id}', [OrderController::class,'deleteOrder'])->name('deleteOrder')->middleware(['checkLogin']);
  
  Route::post('confirmOrder', [OrderController::class,'confirmOrder'])->middleware(['checkLogin'])->name('confirmOrder');

/*|--------------------------------------------------------------------------|
  |Complaint Route                                                           |
  |--------------------------------------------------------------------------|*/


  
  Route::view('complaints','order.complaints')->middleware(['checkLogin'])->name('complaints');
  Route::post('fetchAllComplaint', [ComplaintController::class,'fetchAllComplaint'])->middleware(['checkLogin'])->name('fetchAllComplaint');
  Route::post('fetchAllCloseComplaint', [ComplaintController::class,'fetchAllCloseComplaint'])->middleware(['checkLogin'])->name('fetchAllCloseComplaint');
  Route::post('moveToClose', [ComplaintController::class,'moveToClose'])->name('moveToClose')->middleware(['checkLogin']);
  Route::get('deleteComplaint/{id}', [ComplaintController::class,'deleteComplaint'])->name('deleteComplaint')->middleware(['checkLogin']);

  Route::get('viewComplaint/{id}', [ComplaintController::class,'viewComplaint'])->middleware(['checkLogin'])->name('viewComplaint');
  Route::get('getComplaintForWeb/{id}', [ComplaintController::class,'getComplaintForWeb'])->middleware(['checkLogin'])->name('getComplaintForWeb');


  
/*|--------------------------------------------------------------------------|
  |Review Route                                                              |
  |--------------------------------------------------------------------------|*/


  
  Route::view('reviews','order.review')->middleware(['checkLogin'])->name('reviews');
  Route::post('fetchAllReview', [ReviewController::class,'fetchAllReview'])->middleware(['checkLogin'])->name('fetchAllReview');

  Route::get('deleteReview/{id}', [ReviewController::class,'deleteReview'])->name('deleteReview')->middleware(['checkLogin']);


  Route::post('updateReview', [ReviewController::class,'updateReview'])->middleware(['checkLogin'])->name('updateReview');