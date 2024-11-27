<?php

use App\Http\Controllers\AdminControllerMid;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellProductController;
use App\Http\Controllers\ShoeSalesController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('/foo', function () {
    Artisan::call('storage:link');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPost'])->name('login.submit');
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/register', [LoginController::class, 'registerpost'])->name('registerpost');
});

Route::group(['middleware' => ['custom.rememberme']], function () {
    Route::get('/', [LoginController::class, 'home'])->name('home');
    Route::get('/collection', [HomeController::class, 'collection'])->name('collection');
});

Route::group(['middleware' => 'custom.auth'], function () {
    Route::get('/account', [HomeController::class, 'account'])->name('account');
    Route::post('/account', [HomeController::class, 'updateAccount'])->name('updateAccount'); // Account details
    Route::post('/account-reset', [HomeController::class, 'updatePassword'])->name('changePass'); //change pass
    Route::post('/account-address', [HomeController::class, 'updateAddress'])->name('changeAddress'); //change address
    Route::post('/account-add', [HomeController::class, 'add'])->name('add'); //add Address
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/TryItYourself', [HomeController::class, 'PutItON'])->name('PutItON');
    Route::get('/product/{productName}', [ProductController::class, 'index'])->name('product');
    Route::post('/product', [ProductController::class, 'cart'])->name('cart'); //Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'addr'])->name('cart.index');
    Route::post('/cart-changeAddr', [CartController::class, 'changeAddr'])->name('changeAddr');

    Route::post('/cart-checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::get('/sellProduct', [SellProductController::class, 'index'])->name('sellProduct');
    Route::post('/sellProduct-post', [SellProductController::class, 'newchat'])->name('newchat');
    Route::post('/sellProduct-chat', [SellProductController::class, 'chatPost'])->name('chatPost');
    Route::post('/sellProduct-remove', [SellProductController::class, 'closeChat'])->name('closeChat');
    Route::get('/getChatContent/{chatId}', [SellProductController::class, 'getChatContent']);


    Route::post('/remove-cart', [CartController::class, 'removeCart'])->name('removeCart'); //Cart

    Route::post('/collection-post', [HomeController::class, 'favorites'])->name('favorites');  //favorites


    Route::get('/survey', [SurveyController::class, 'showSurveyForm']);
    Route::post('/survey', [SurveyController::class, 'handleSurvey']);  

    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    
    Route::post('/paypal/payment', [CartController::class, 'paypalPayment'])->name('paypal.payment');
    Route::post('/paypal/checkout', [CartController::class, 'paypalProcess'])->name('paypal.checkout'); // Combined method
    Route::get('/paypal/success', [CartController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('/paypal/cancel', [CartController::class, 'paypalCancel'])->name('paypal.cancel'); // Optional: Handle cancellations
    

    Route::get('/order/success', [CartController::class, 'orderSuccess'])->name('order.success');
    Route::get('/order/failed', [CartController::class, 'orderFailed'])->name('order.failed');

    Route::get('/get-provinces/{regionId}', [HomeController::class, 'getProvinces'])->name('get.provinces');
    Route::get('/get-municipalities/{provinceId}', [HomeController::class, 'getMunicipalities'])->name('get.municipalities');;
    Route::get('/get-barangays/{municipalityId}', [HomeController::class, 'getBarangays'])->name('get.barangays');;


});

Route::group(['middleware' => 'admin.auth'], function () {
    Route::get('/admin', [AdminControllerMid::class, 'index'])->name('admin.home');
    Route::get('/admin-logout', [AdminControllerMid::class, 'logoutAdmin'])->name('logoutAdmin');

    Route::get('/editProducts', [AdminControllerMid::class, 'editProducts'])->name('editProducts');
    Route::get('/manageProducts', [AdminControllerMid::class, 'manageProducts'])->name('manageProducts');
    Route::get('/removeProducts', [AdminControllerMid::class, 'removeProducts']);
    Route::post('/removeProductsPost', [AdminControllerMid::class, 'removeProductsPost'])->name('removeProductsPost');
    Route::post('/manageProductsPost', [AdminControllerMid::class, 'manageProductsPost'])->name('manageProductsPost');
    Route::post('/editProducts', [AdminControllerMid::class, 'editProductsPost'])->name('editProductsPost');
    Route::post('/addProducts-post', [AdminControllerMid::class, 'addProductsPost'])->name('addProductsPost');
    Route::post('/addBrand', [AdminControllerMid::class, 'addBrand'])->name('addBrand');


    Route::post('/orderUpdate', [AdminControllerMid::class, 'orderUpdate'])->name('orderUpdate');



    Route::get('/sales-data/line', [ShoeSalesController::class, 'getLineChart'])->name('shoe.sales.line');
    Route::get('/sales-data/pie', [ShoeSalesController::class, 'getPieChart'])->name('shoe.sales.pie');
        
    Route::get('/admin/comparison', [ShoeSalesController::class, 'getMonthlyComparison'])->name('admin.comparison');
    Route::get('/admin/peak-off', [ShoeSalesController::class, 'getPeakAndOffMonths'])->name('admin.peakoff');
    Route::get('admin/profitable', [ShoeSalesController::class, 'getMostProfitableBrandAndCategory'])->name('admin.profitable');
    Route::get('/admin/forecast', [ShoeSalesController::class, 'getForecast'])->name('admin.forecast');

    Route::get('/admin/survey-results', [ShoeSalesController::class, 'getSurveyResults'])->name('admin.surveyresults');

    

    Route::post('/upload-images', [DropzoneController::class, 'uploadImages'])->name('images.upload');
    Route::get('/upload-images/{id}', [DropzoneController::class, 'index'])->name('upload.form');
    Route::get('/fit-images/{id}', [DropzoneController::class, 'fit'])->name('fit.form');


    Route::get('/images', [DropzoneController::class, 'showImages'])->name('images.show');
    Route::get('/messages', [SellProductController::class, 'messages'])->name('messages');

    Route::post('/sellProduct-chatAdmin', [SellProductController::class, 'chatPostAdmin'])->name('chatPostAdmin');
    Route::get('/getChatContentAdmin/{id}', [SellProductController::class, 'getChatContentAdmin'])->name('getChatContentAdmin');

    Route::get('/addProducts', [AdminControllerMid::class, 'addProducts'])->name('addProducts');

    Route::post('/sellProduct-removeAdmin', [SellProductController::class, 'closeChatAdmin'])->name('closeChatAdmin');

    Route::post('/save-shoe-dimensions', [DropzoneController::class, 'saveDimensions'])->name('save.shoe.dimensions');
   
});

