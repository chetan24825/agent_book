<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\AizUploadController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Basic\BasicController;
use App\Http\Controllers\Basic\InstallmentController;
use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\User\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'toLogin'])->name('login');
    Route::post('/login', [UserController::class, 'toLoginPost'])->name('login.post');

    Route::get('/user/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('user.password.request');
    Route::post('/user/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('user.password.email');
    Route::get('/user/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/user/reset-password', [ResetPasswordController::class, 'reset'])->name('user.password.update');
});

Route::get('/logout', function () {
    Auth::logout(); // Logs out the current user
    request()->session()->invalidate(); // Invalidate the session
    request()->session()->regenerateToken(); // Regenerate the CSRF token for security
    return redirect()->route('login'); // Redirect to the login page (or any other route)
})->name('logout');



Route::group(['middleware' => ['auth:web', 'user.active'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/dashboard', [UserController::class, 'toUserDashboard'])->name('dashboard');

    // Profile Update
    Route::get('profile', [UserController::class, 'UserProfile'])->name('profile');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('profileupdate');
    Route::post('password/update', [UserController::class, 'updatePassword'])->name('password.update');
    Route::post('kyc/update', [UserController::class, 'updateKyc'])->name('kyc.update');
    Route::post('bank/update', [UserController::class, 'updateBankDetails'])->name('bank.update');


    //Products
    Route::get('/products', [UserController::class, 'toproducts'])->name('products');
    Route::get('carts', [UserController::class, 'Cartdetail'])->name('carts');
    Route::post('checkout', [BasicController::class, 'toCheck'])->name('checkout');
    Route::get('thankyou', [BasicController::class, 'toThankyou'])->name('thankyou');


    Route::post('cart/add', [BasicController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/remove/{id}', [BasicController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update/{id}', [BasicController::class, 'updateCart'])->name('cart.update');


    Route::get('orders', [UserController::class, 'toOrder'])->name('order');
    Route::get('order/invoice/{id}', [UserController::class, 'invoice'])->name('order.invoice');
    Route::get('order/commission/{id}', [InstallmentController::class, 'toCommissionUser'])->name('order.commission');
    Route::post('order/installment', [InstallmentController::class, 'toinstallment'])->name('order.installment');





    Route::get('favourites', [UserController::class, 'VisitingCards'])->name('visitingcards');
    Route::delete('favourite/delete/{id}', [UserController::class, 'toDeleteFavourite'])->name('user.favourite');

    // Hello Chetan KUMar

    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');
});


Route::post('/webhook/github', [WebhookController::class, 'handleWebhook']);
