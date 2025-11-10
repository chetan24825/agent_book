<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Basic\BasicController;
use App\Http\Controllers\Client\MyClientController;


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AgentController::class, 'toAgentLogin'])->name('login');
    Route::post('/login', [AgentController::class, 'toAgentLoginPost']);
});

Route::group(['middleware' => ['auth:agent']], function () {
    Route::get('/dashboard', [AgentController::class, 'toAgentDashboard'])->name('dashboard');

    // profile
    Route::get('/profile', [AgentController::class, 'toAgentprofile'])->name('profile');
    Route::post('/profile', [AgentController::class, 'toAgentprofileUpdate']);
    Route::post('/update-password', [AgentController::class, 'updatePassword'])->name('profile.updatePassword');

    //Products
    Route::get('/products', [AgentController::class, 'toproducts'])->name('products');

    Route::post('/cart/add', [BasicController::class, 'addToCart'])->name('cart.add');


    //My Clients
    Route::get('/my-clients', [MyClientController::class, 'toclients'])->name('ourClients');
    Route::get('/clients/new', [MyClientController::class, 'tonewclients'])->name('newClients');
    Route::post('/clients/new', [MyClientController::class, 'toClientStore']);
    Route::delete('/clients/delete/{id}', [MyClientController::class, 'toClientDelete'])->name('newClients.delete');
    Route::put('/clients/update/{id}', [MyClientController::class, 'toClientupdate'])->name('clients.update');




    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');
});
