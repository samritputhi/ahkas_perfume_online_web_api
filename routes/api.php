<?php

use App\Ahkas\Application\Address\Controller\CreateAddressController;
use App\Ahkas\Application\Address\Controller\DeleteAddressController;
use App\Ahkas\Application\Address\Controller\GetAllAddressController;
use App\Ahkas\Application\Address\Controller\UpdateAddressController;
use App\Ahkas\Application\Address\Controller\UpdateDefaultAddressController;
use App\Ahkas\Application\Auth\CheckPhoneExistController;
use App\Ahkas\Application\Auth\UserRegisterController;
use App\Ahkas\Application\Brand\GetAllBrandController;
use App\Ahkas\Application\Cart\AddCartItemController;
use App\Ahkas\Application\Cart\CartCheckOutController;
use App\Ahkas\Application\Cart\GetAllPaymentMethodController;
use App\Ahkas\Application\Cart\GetCartDetailController;
use App\Ahkas\Application\Cart\RemoveCartItemController;
use App\Ahkas\Application\Cart\UpdateQtyCartItemController;
use App\Ahkas\Application\Category\GetAllCategoryController;
use App\Ahkas\Application\Favorite\GetFavoriteProductController;
use App\Ahkas\Application\Favorite\UserFavoriteProductController;
use App\Ahkas\Application\Home\HomeBadgeController;
use App\Ahkas\Application\Home\HomeSectionController;
use App\Ahkas\Application\Notification\GetAllNotificationController;
use App\Ahkas\Application\Notification\RegisterUserDeviceController;
use App\Ahkas\Application\Notification\RemoveUserDeviceController;
use App\Ahkas\Application\Order\GetAllMyOrderController;
use App\Ahkas\Application\Product\GetAllProductController;
use App\Ahkas\Application\Product\GetFlashSaleProductController;
use App\Ahkas\Application\Product\GetPopularProductController;
use App\Ahkas\Application\Product\GetProductDetailController;
use App\Ahkas\Application\Product\GetPromotionProductController;
use App\Ahkas\Application\Search\DeleteRecentSearchController;
use App\Ahkas\Application\Search\GetPopularSearchController;
use App\Ahkas\Application\Search\GetRecentSearchController;
use App\Ahkas\Application\Search\MakeRecentSearchController;
use App\Ahkas\Application\SlideShow\GetAllSlideShowController;
use App\Ahkas\Application\User\UserChangeProfileController;
use App\Ahkas\Application\User\UserGetProfileController;
use App\Ahkas\Application\User\UserLoginController;
use App\Ahkas\Support\Telegram\TelegramBotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('localization')->group(function () {

    Route::get('health-check', function () {
        return Response('ok', 200);
    });

    Route::prefix('webhook')->group(function () {
        Route::post('/telegram-bot', TelegramBotController::class);
    });

    Route::prefix('home')->middleware('auth:sanctum')->group(function () {
        Route::get('/slide-shows', GetAllSlideShowController::class);
        Route::get('/categories', GetAllCategoryController::class);
        Route::get('/brands', GetAllBrandController::class);
        Route::get('/products', GetAllProductController::class);
        Route::get('/flash-sale', GetFlashSaleProductController::class);
        Route::get('/popular-product', GetPopularProductController::class);
        Route::get('/promotion-product', GetPromotionProductController::class);
        Route::get('/home-section', HomeSectionController::class);
        Route::get('/badge', HomeBadgeController::class);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/login', UserLoginController::class);
        Route::post('/register', UserRegisterController::class);
        Route::post('/check-exist', CheckPhoneExistController::class);
    });

    Route::prefix('user')->middleware('auth:sanctum')->group(function () {
        Route::post('/favorite/{id}', UserFavoriteProductController::class);
        Route::get('/favorite', GetFavoriteProductController::class);
    });

    Route::prefix('profile')->middleware('auth:sanctum')->group(function () {
        Route::get('/info', UserGetProfileController::class);
        Route::post('/update-profile', UserChangeProfileController::class);
        // Route::post('/update-info', UserUpdateInfoController::class);
    });

    Route::prefix('address')->middleware('auth:sanctum')->group(function () {
        Route::get('/all', GetAllAddressController::class);
        Route::post('/create', CreateAddressController::class);
        Route::put('/update/{id}', UpdateAddressController::class);
        Route::put('/default/{id}', UpdateDefaultAddressController::class);
        Route::delete('/delete/{id}', DeleteAddressController::class);
    });

    Route::prefix('search')->middleware('auth:sanctum')->group(function () {
        Route::get('/recent-search', GetRecentSearchController::class);
        Route::post('/recent-search', MakeRecentSearchController::class);
        Route::delete('/recent-search/{id}', DeleteRecentSearchController::class);
        Route::get('/popular-search', GetPopularSearchController::class);
    });

    Route::prefix('product')->middleware('auth:sanctum')->group(function () {
        Route::get('/{id}', GetProductDetailController::class);
    });

    Route::prefix('cart')->middleware('auth:sanctum')->group(function () {
        Route::get('cart-detail', GetCartDetailController::class);
        Route::post('add-item', AddCartItemController::class);
        Route::put('update-item', UpdateQtyCartItemController::class);
        Route::delete('delete-item/{cartItem}', RemoveCartItemController::class);
        Route::post('checkout', CartCheckOutController::class);
        Route::get('payment-method', GetAllPaymentMethodController::class);
    });

    Route::prefix('notification')->middleware('auth:sanctum')->group(function () {
        Route::post('/register-device', RegisterUserDeviceController::class);
        Route::delete('/remove-device', RemoveUserDeviceController::class);
        Route::get('/all-notification', GetAllNotificationController::class);
    });

    Route::prefix('orders')->middleware('auth:sanctum')->group(function () {
        Route::get('/my-order', GetAllMyOrderController::class);
    });
});
