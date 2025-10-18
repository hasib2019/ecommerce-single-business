<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\User;

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

Route::get('/test', function() {
    return 'Test route works!';
});

Route::get('/test2', function() {
    return 'Test route 2 is working!';
});

Route::get('/', [\App\Http\Controllers\WebsiteController::class, 'index'])->name('home');
Route::get('/product/{id}', [\App\Http\Controllers\WebsiteController::class, 'product'])->name('product');
Route::get('/category/{slug}', [\App\Http\Controllers\WebsiteController::class, 'category'])->name('category');
Route::get('/page/{slug}', [\App\Http\Controllers\WebsiteController::class, 'page'])->name('page');
Route::get('/shop', [\App\Http\Controllers\WebsiteController::class, 'shop'])->name('shop');

Route::get('/getProducts', [\App\Http\Controllers\WebsiteController::class, 'loadProducts'])->name('loadProducts');
Route::get('/getCategoryProducts', [\App\Http\Controllers\WebsiteController::class, 'loadCategoryProducts'])->name('loadCategoryProducts');

Route::resource('/checkout', \App\Http\Controllers\CartController::class);
Route::get('/mini_cart', [\App\Http\Controllers\CartController::class, 'mini_cart'])->name('mini_cart');
Route::get('/miniCart', [\App\Http\Controllers\CartController::class, 'miniCart'])->name('miniCart');
Route::get('/updateQuantity', [\App\Http\Controllers\CartController::class, 'updateQuantity'])->name('updateQuantity');
Route::get('/updateDeliveryCharge', [\App\Http\Controllers\CartController::class, 'updateDeliveryCharge'])->name('updateDeliveryCharge');
Route::post('/placeOrder', [\App\Http\Controllers\CartController::class, 'placeOrder'])->name('placeOrder');
Route::get('/checkout/order-received/{id}', [\App\Http\Controllers\CartController::class, 'orderRecived'])->name('placeOrder');

//Route::get('/', function () {
//    return redirect('login');
//});

Route::get('pathao', 'PathaoController@pathao')->name('pathao');
Route::get('deliveryTiger', 'DeliveryTigerController@deliveryTiger')->name('deliveryTiger');
Route::get('redx', 'PathaoController@redx')->name('redx');

Route::get('/user', function (){
    return redirect('user/dashboard');
});
Route::get('/admin', function (){
    return redirect('admin/dashboard');
});

Auth::routes(['except' => 'register']);

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', '\App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::get('dashboard/getData', '\App\Http\Controllers\Admin\DashboardController@getData')->name('getData');
    Route::get('dashboard/stockOutProduct', '\App\Http\Controllers\Admin\DashboardController@stockOutProduct')->name('stockOutProduct');
    Route::get('dashboard/recentUpdate', '\App\Http\Controllers\Admin\DashboardController@recentUpdate')->name('recentUpdate');
    Route::get('dashboard/getNotification', '\App\Http\Controllers\Admin\DashboardController@getNotification')->name('getNotification');


    //

    // Products
    Route::get('product/oldProductSync', '\App\Http\Controllers\Admin\ProductController@oldProductSync')->name('oldProductSync');
    Route::get('product/productSync', '\App\Http\Controllers\Admin\ProductController@productSync')->name('productSync');
    Route::post('product/image', '\App\Http\Controllers\Admin\ProductController@image')->name('image');
    Route::post('product/status', '\App\Http\Controllers\Admin\ProductController@status')->name('status');
    Route::post('product/category','\App\Http\Controllers\Admin\ProductController@category');
    Route::get('product/delete','\App\Http\Controllers\Admin\ProductController@delete')->name('delete');
    Route::resource('product', '\App\Http\Controllers\Admin\ProductController');

    // Media
    Route::get('media/get','\App\Http\Controllers\Admin\MediaController@get')->name('get');
    Route::get('media/delete','\App\Http\Controllers\Admin\MediaController@delete')->name('delete');
    Route::get('media/iframeget','\App\Http\Controllers\Admin\MediaController@iframeget')->name('iframeget');
    Route::get('media/iframe','\App\Http\Controllers\Admin\MediaController@iframe')->name('iframe');
    Route::resource('media','\App\Http\Controllers\Admin\MediaController');

    // Category
    Route::post('category/status','\App\Http\Controllers\Admin\CategoryController@status');
    Route::get('category/get','\App\Http\Controllers\Admin\CategoryController@get');
    Route::get('category/delete','\App\Http\Controllers\Admin\CategoryController@delete')->name('delete');
    Route::resource('category','\App\Http\Controllers\Admin\CategoryController');


    // Store
    Route::post('store/status', '\App\Http\Controllers\Admin\StoreController@status')->name('status');
    Route::resource('store', '\App\Http\Controllers\Admin\StoreController');

    // Supplier

    Route::post('supplier/status', '\App\Http\Controllers\Admin\SupplierController@status')->name('status');
    Route::resource('supplier', '\App\Http\Controllers\Admin\SupplierController');

    // Purchase
    Route::get('purchase/supplier', '\App\Http\Controllers\Admin\PurchaseController@supplier')->name('supplier');
    Route::get('purchase/product', '\App\Http\Controllers\Admin\PurchaseController@product')->name('product');
    Route::resource('purchase', '\App\Http\Controllers\Admin\PurchaseController');

    // Product Stock
    Route::resource('stock', '\App\Http\Controllers\Admin\StockController');

    // Notification
    Route::resource('notification', '\App\Http\Controllers\Admin\NotificationController');


    // Order



    Route::get('order/deleteAll', '\App\Http\Controllers\Admin\OrderController@deleteAll')->name('deleteAll');
    Route::get('order/status', '\App\Http\Controllers\Admin\OrderController@status')->name('status');
    Route::get('order/orderSync', '\App\Http\Controllers\Admin\OrderController@orderSync')->name('orderSync');
    Route::get('order/view', '\App\Http\Controllers\Admin\OrderController@view')->name('view');

    Route::get('order/status/{status}', '\App\Http\Controllers\Admin\OrderController@ordersByStatus')->name('ordersByStatus');

    Route::get('order/assign', '\App\Http\Controllers\Admin\OrderController@assign')->name('assign');
    Route::get('order/changeStatusByCheckbox', '\App\Http\Controllers\Admin\OrderController@changeStatusByCheckbox')->name('changeStatusByCheckbox');
    Route::get('order/getNotes', '\App\Http\Controllers\Admin\OrderController@getNotes')->name('getNotes');
    Route::get('order/updateNotes', '\App\Http\Controllers\Admin\OrderController@updateNotes')->name('updateNotes');
    Route::get('order/oldOrders', '\App\Http\Controllers\Admin\OrderController@oldOrders')->name('oldOrders');


    Route::get('order/product', '\App\Http\Controllers\Admin\OrderController@product')->name('product');
    Route::get('order/stores', '\App\Http\Controllers\Admin\OrderController@stores')->name('stores');
    Route::get('order/users', '\App\Http\Controllers\Admin\OrderController@users')->name('users');
    Route::get('order/courier', '\App\Http\Controllers\Admin\OrderController@courier')->name('courier');
    Route::get('order/city', '\App\Http\Controllers\Admin\OrderController@city')->name('city');
    Route::get('order/zone', '\App\Http\Controllers\Admin\OrderController@zone')->name('zone');
    Route::get('order/paymenttype', '\App\Http\Controllers\Admin\OrderController@paymenttype')->name('paymenttype');
    Route::get('order/paymentnumber', '\App\Http\Controllers\Admin\OrderController@paymentnumber')->name('paymentnumber');


    Route::get('order/countOrders', '\App\Http\Controllers\Admin\OrderController@countOrders')->name('countOrders');
    Route::get('order/invoice', '\App\Http\Controllers\Admin\OrderController@invoice')->name('invoice');
    Route::get('order/storeInvoice', '\App\Http\Controllers\Admin\OrderController@storeInvoice')->name('storeInvoice');
    Route::get('order/invoice/{id}', '\App\Http\Controllers\Admin\OrderController@viewInvoice')->name('viewInvoice');
    Route::get('order/memoUpdate', '\App\Http\Controllers\Admin\OrderController@memoUpdate')->name('memoUpdate');



    // Send Sms
    Route::get('order/sendNumber', '\App\Http\Controllers\Admin\OrderController@sendNumber')->name('sendNumber');

    Route::resource('order', '\App\Http\Controllers\Admin\OrderController');

    // Order Type

    // Payment Type
    Route::post('payment/type/status', '\App\Http\Controllers\Admin\PaymentTypeController@status')->name('status');
    Route::resource('payment/type', '\App\Http\Controllers\Admin\PaymentTypeController');

    // Payment
    Route::get('payment/paymentType', '\App\Http\Controllers\Admin\PaymentController@paymentType')->name('paymentType');
    Route::post('payment/status', '\App\Http\Controllers\Admin\PaymentController@status')->name('status');
    Route::resource('payment', '\App\Http\Controllers\Admin\PaymentController');

    // Courier
    Route::post('courier/status', '\App\Http\Controllers\Admin\CourierController@status')->name('status');
    Route::resource('courier', '\App\Http\Controllers\Admin\CourierController');

    // City
    Route::post('city/status', '\App\Http\Controllers\Admin\CityController@status')->name('status');
    Route::get('city/courier', '\App\Http\Controllers\Admin\CityController@courier')->name('courier');
    Route::resource('city', '\App\Http\Controllers\Admin\CityController');

    // Zone
    Route::get('zone/courier', '\App\Http\Controllers\Admin\ZoneController@courier')->name('courier');
    Route::get('zone/city', '\App\Http\Controllers\Admin\ZoneController@city')->name('city');
    Route::post('zone/status', '\App\Http\Controllers\Admin\ZoneController@status')->name('status');
    Route::resource('zone', '\App\Http\Controllers\Admin\ZoneController');

    // User
    Route::get('user/users', '\App\Http\Controllers\Admin\UserController@users')->name('users');
    Route::get('user/role', '\App\Http\Controllers\Admin\UserController@role')->name('role');
    Route::get('user/status', '\App\Http\Controllers\Admin\UserController@status')->name('status');
    Route::get('user/login/{id}', function($id) {
       $user = User::find($id);;
        Auth::login($user);
        return redirect()->to('/login');
    })->name('admin');

    Route::resource('user', '\App\Http\Controllers\Admin\UserController');
    
    

    // Report
    Route::get('report/users', '\App\Http\Controllers\Admin\Report@users')->name('users');
    Route::get('report/dateCourierUser', '\App\Http\Controllers\Admin\Report@dateCourierUser')->name('dateCourierUser');
    Route::get('report/getOrdersOnDateCourierUser', '\App\Http\Controllers\Admin\Report@getOrdersOnDateCourierUser')->name('getOrdersOnDateCourierUser');
    Route::get('report/multipleDateCourierUser', '\App\Http\Controllers\Admin\Report@multipleDateCourierUser')->name('multipleDateCourierUser');
    Route::get('report/getMultipleDateCourierUser', '\App\Http\Controllers\Admin\Report@getMultipleDateCourierUser')->name('getMultipleDateCourierUser');
    Route::get('report/dateCourier', '\App\Http\Controllers\Admin\Report@dateCourier')->name('dateCourier');
    Route::get('report/getDateCourier', '\App\Http\Controllers\Admin\Report@getDateCourier')->name('getDateCourier');
    Route::get('report/dateUser', '\App\Http\Controllers\Admin\Report@dateUser')->name('dateUser');
    Route::get('report/getDateUser', '\App\Http\Controllers\Admin\Report@getDateUser')->name('getDateUser');
    Route::get('report/product', '\App\Http\Controllers\Admin\Report@product')->name('product');
    Route::get('report/getProduct', '\App\Http\Controllers\Admin\Report@getProduct')->name('getProduct');
    Route::get('report/payment', '\App\Http\Controllers\Admin\Report@payment')->name('payment');
    Route::get('report/getPayment', '\App\Http\Controllers\Admin\Report@getPayment')->name('getPayment');
    Route::get('report/paymentID', '\App\Http\Controllers\Admin\Report@paymentID')->name('paymentID');
    Route::get('report/paymentType', '\App\Http\Controllers\Admin\Report@paymentType')->name('paymentType');


    Route::get('menu', function () {
        return view('admin.menu');
    });

    Route::get('page/delete', '\App\Http\Controllers\Admin\PageController@delete')->name('page.delete');
    Route::resource('page', '\App\Http\Controllers\Admin\PageController');
    Route::post('page/status', '\App\Http\Controllers\Admin\PageController@status')->name('status');

    Route::post('slider/status','\App\Http\Controllers\Admin\SliderController@status');
    Route::get('slider/delete','\App\Http\Controllers\Admin\SliderController@delete')->name('delete');
    Route::resource('slider', '\App\Http\Controllers\Admin\SliderController');


    Route::post('setting/getSlider', '\App\Http\Controllers\Admin\SettingController@getSlider')->name('getSlider');
     Route::resource('setting', '\App\Http\Controllers\Admin\SettingController');


});

Route::group(['as' => 'manager.', 'prefix' => 'manager', 'middleware' => ['auth', 'manager']], function () {

    Route::get('dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/getData', [\App\Http\Controllers\Manager\DashboardController::class, 'getData'])->name('getData');
    Route::get('dashboard/stockOutProduct', [\App\Http\Controllers\Manager\DashboardController::class, 'stockOutProduct'])->name('stockOutProduct');
    Route::get('dashboard/recentUpdate', [\App\Http\Controllers\Manager\DashboardController::class, 'recentUpdate'])->name('recentUpdate');
    Route::get('dashboard/getNotification', [\App\Http\Controllers\Manager\DashboardController::class, 'getNotification'])->name('getNotification');


    //

    // Products
    Route::get('product/productSync', '\App\Http\Controllers\Manager\ProductController@productSync')->name('productSync');
    Route::post('product/image', '\App\Http\Controllers\Manager\ProductController@image')->name('image');
    Route::post('product/status', '\App\Http\Controllers\Manager\ProductController@status')->name('status');
    Route::resource('product', '\App\Http\Controllers\Manager\ProductController');

    // Store
    Route::post('store/status', '\App\Http\Controllers\Manager\StoreController@status')->name('status');
    Route::resource('store', '\App\Http\Controllers\Manager\StoreController');

    // Supplier

    Route::post('supplier/status', '\App\Http\Controllers\Manager\SupplierController@status')->name('status');
    Route::resource('supplier', '\App\Http\Controllers\Manager\SupplierController');

    // Purchase
    Route::get('purchase/supplier', '\App\Http\Controllers\Manager\PurchaseController@supplier')->name('supplier');
    Route::get('purchase/product', '\App\Http\Controllers\Manager\PurchaseController@product')->name('product');
    Route::resource('purchase', '\App\Http\Controllers\Manager\PurchaseController');

    // Product Stock
    Route::resource('stock', '\App\Http\Controllers\Manager\StockController');

    // Notification
    Route::resource('notification', '\App\Http\Controllers\Manager\NotificationController');


    // Order



    Route::get('order/deleteAll', '\App\Http\Controllers\Admin\OrderController@deleteAll')->name('deleteAll');
    Route::get('order/status', '\App\Http\Controllers\Admin\OrderController@status')->name('status');
    Route::get('order/orderSync', '\App\Http\Controllers\Admin\OrderController@orderSync')->name('orderSync');
    Route::get('order/view', '\App\Http\Controllers\Admin\OrderController@view')->name('view');

    Route::get('order/status/{status}', '\App\Http\Controllers\Admin\OrderController@ordersByStatus')->name('ordersByStatus');

    Route::get('order/assign', '\App\Http\Controllers\Admin\OrderController@assign')->name('assign');
   
    Route::get('order/changeStatusByCheckbox', '\App\Http\Controllers\Admin\OrderController@changeStatusByCheckbox')->name('changeStatusByCheckbox');
    Route::get('order/getNotes', '\App\Http\Controllers\Admin\OrderController@getNotes')->name('getNotes');
    Route::get('order/updateNotes', '\App\Http\Controllers\Admin\OrderController@updateNotes')->name('updateNotes');
    Route::get('order/oldOrders', '\App\Http\Controllers\Admin\OrderController@oldOrders')->name('oldOrders'); 


    Route::get('order/product', '\App\Http\Controllers\Admin\OrderController@product')->name('product');
    Route::get('order/stores', '\App\Http\Controllers\Admin\OrderController@stores')->name('stores');
    Route::get('order/users', '\App\Http\Controllers\Admin\OrderController@users')->name('users');
    Route::get('order/courier', '\App\Http\Controllers\Admin\OrderController@courier')->name('courier');
    Route::get('order/city', '\App\Http\Controllers\Admin\OrderController@city')->name('city');
    Route::get('order/zone', '\App\Http\Controllers\Admin\OrderController@zone')->name('zone');
    Route::get('order/paymenttype', '\App\Http\Controllers\Admin\OrderController@paymenttype')->name('paymenttype');
    Route::get('order/paymentnumber', '\App\Http\Controllers\Admin\OrderController@paymentnumber')->name('paymentnumber');


    Route::get('order/countOrders', '\App\Http\Controllers\Admin\OrderController@countOrders')->name('countOrders');
    Route::get('order/invoice', '\App\Http\Controllers\Admin\OrderController@invoice')->name('invoice');
    Route::get('order/storeInvoice', '\App\Http\Controllers\Admin\OrderController@storeInvoice')->name('storeInvoice');
    Route::get('order/invoice/{id}', '\App\Http\Controllers\Admin\OrderController@viewInvoice')->name('viewInvoice');
    Route::get('order/memoUpdate', '\App\Http\Controllers\Admin\OrderController@memoUpdate')->name('memoUpdate');



    // Send Sms
    Route::get('order/sendNumber', '\App\Http\Controllers\Admin\OrderController@sendNumber')->name('sendNumber');

    Route::resource('order', '\App\Http\Controllers\Admin\OrderController');

    // Order Type

    // Payment Type
    Route::post('payment/type/status', '\App\Http\Controllers\Manager\PaymentTypeController@status')->name('status');
    Route::resource('payment/type', '\App\Http\Controllers\Manager\PaymentTypeController');

    // Payment
    Route::get('payment/paymentType', '\App\Http\Controllers\Manager\PaymentController@paymentType')->name('paymentType');
    Route::post('payment/status', '\App\Http\Controllers\Manager\PaymentController@status')->name('status');
    Route::resource('payment', '\App\Http\Controllers\Manager\PaymentController');

    // Courier
    Route::post('courier/status', '\App\Http\Controllers\Manager\CourierController@status')->name('status');
    Route::resource('courier', '\App\Http\Controllers\Manager\CourierController');

    // City
    Route::post('city/status', '\App\Http\Controllers\Manager\CityController@status')->name('status');
    Route::get('city/courier', '\App\Http\Controllers\Manager\CityController@courier')->name('courier');
    Route::resource('city', '\App\Http\Controllers\Manager\CityController');

    // Zone
    Route::get('zone/courier', '\App\Http\Controllers\Manager\ZoneController@courier')->name('courier');
    Route::get('zone/city', '\App\Http\Controllers\Manager\ZoneController@city')->name('city');
    Route::post('zone/status', '\App\Http\Controllers\Manager\ZoneController@status')->name('status');
    Route::resource('zone', '\App\Http\Controllers\Manager\ZoneController');

    // User
    Route::get('user/users', '\App\Http\Controllers\Manager\UserController@users')->name('users');
    Route::get('user/role', '\App\Http\Controllers\Manager\UserController@role')->name('role');
    Route::get('user/status', '\App\Http\Controllers\Manager\UserController@status')->name('status');
    Route::resource('user', '\App\Http\Controllers\Manager\UserController');

    // Report
    Route::get('report/users', '\App\Http\Controllers\Manager\Report@users')->name('users');
    Route::get('report/dateCourierUser', '\App\Http\Controllers\Manager\Report@dateCourierUser')->name('dateCourierUser');
    Route::get('report/getOrdersOnDateCourierUser', '\App\Http\Controllers\Manager\Report@getOrdersOnDateCourierUser')->name('getOrdersOnDateCourierUser');
    Route::get('report/multipleDateCourierUser', '\App\Http\Controllers\Manager\Report@multipleDateCourierUser')->name('multipleDateCourierUser');
    Route::get('report/getMultipleDateCourierUser', '\App\Http\Controllers\Manager\Report@getMultipleDateCourierUser')->name('getMultipleDateCourierUser');
    Route::get('report/dateCourier', '\App\Http\Controllers\Manager\Report@dateCourier')->name('dateCourier');
    Route::get('report/getDateCourier', '\App\Http\Controllers\Manager\Report@getDateCourier')->name('getDateCourier');
    Route::get('report/dateUser', '\App\Http\Controllers\Manager\Report@dateUser')->name('dateUser');
    Route::get('report/getDateUser', '\App\Http\Controllers\Manager\Report@getDateUser')->name('getDateUser');
    
    Route::get('report/product', '\App\Http\Controllers\Manager\Report@product')->name('product');
    Route::get('report/getProduct', '\App\Http\Controllers\Manager\Report@getProduct')->name('getProduct');
    
    Route::get('report/payment', '\App\Http\Controllers\Manager\Report@payment')->name('payment');
    Route::get('report/getPayment', '\App\Http\Controllers\Manager\Report@getPayment')->name('getPayment');
    Route::get('report/paymentID', '\App\Http\Controllers\Manager\Report@paymentID')->name('paymentID');
    Route::get('report/paymentType', '\App\Http\Controllers\Manager\Report@paymentType')->name('paymentType');});
    


Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth', 'user']], function () {
    Route::get('dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/getData', [\App\Http\Controllers\User\DashboardController::class, 'getData'])->name('getData');


    // Order

    Route::get('order/deleteAll', '\App\Http\Controllers\User\OrderController@deleteAll')->name('deleteAll');
    Route::get('order/status', '\App\Http\Controllers\User\OrderController@status')->name('status');
    Route::get('order/orderSync', '\App\Http\Controllers\User\OrderController@orderSync')->name('orderSync');
    Route::get('order/view', '\App\Http\Controllers\User\OrderController@view')->name('view');

    Route::get('order/status/{status}', '\App\Http\Controllers\User\OrderController@ordersByStatus')->name('ordersByStatus');

    Route::get('order/assign', '\App\Http\Controllers\User\OrderController@assign')->name('assign');
    Route::get('order/changeStatusByCheckbox', '\App\Http\Controllers\User\OrderController@changeStatusByCheckbox')->name('changeStatusByCheckbox');
    Route::get('order/getNotes', '\App\Http\Controllers\User\OrderController@getNotes')->name('getNotes');
    Route::get('order/updateNotes', '\App\Http\Controllers\User\OrderController@updateNotes')->name('updateNotes');
    Route::get('order/oldOrders', '\App\Http\Controllers\User\OrderController@oldOrders')->name('oldOrders');


    Route::get('order/product', '\App\Http\Controllers\User\OrderController@product')->name('product');
    Route::get('order/stores', '\App\Http\Controllers\User\OrderController@stores')->name('stores');
    Route::get('order/courier', '\App\Http\Controllers\User\OrderController@courier')->name('courier');
    Route::get('order/city', '\App\Http\Controllers\User\OrderController@city')->name('city');
    Route::get('order/zone', '\App\Http\Controllers\User\OrderController@zone')->name('zone');
    Route::get('order/paymenttype', '\App\Http\Controllers\User\OrderController@paymenttype')->name('paymenttype');
    Route::get('order/paymentnumber', '\App\Http\Controllers\User\OrderController@paymentnumber')->name('paymentnumber');

    Route::get('order/complain', '\App\Http\Controllers\User\OrderController@complain')->name('complain');
    Route::get('order/complainOrder', '\App\Http\Controllers\User\OrderController@complainOrder')->name('complainOrder');


    Route::get('order/countOrders', '\App\Http\Controllers\User\OrderController@countOrders')->name('countOrders');
    Route::get('order/invoice', '\App\Http\Controllers\User\OrderController@invoice')->name('invoice');
    Route::get('order/storeInvoice', '\App\Http\Controllers\User\OrderController@storeInvoice')->name('storeInvoice');
    Route::get('order/invoice/{id}', '\App\Http\Controllers\User\OrderController@viewInvoice')->name('viewInvoice');
    Route::get('order/memoUpdate', '\App\Http\Controllers\User\OrderController@memoUpdate')->name('memoUpdate');

    // Send Sms
    Route::get('order/sendNumber', '\App\Http\Controllers\User\OrderController@sendNumber')->name('sendNumber');

    Route::resource('order', '\App\Http\Controllers\User\OrderController');


});


