<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Basic\ProductController;
use App\Http\Controllers\Basic\CategoryController;
use App\Http\Controllers\Basic\WithdrawalController;
use App\Http\Controllers\Basic\InstallmentController;
use App\Http\Controllers\Management\UsersManagementController;
use App\Http\Controllers\Management\AgentsManagementController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AdminController::class, 'toAdminLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'toAdminLoginPost']);
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'toAdminDashboard'])->name('dashboard');

    // Agents
    Route::get('/agents', [AgentsManagementController::class, 'toagents'])->name('agents');
    Route::get('/agents/new', [AgentsManagementController::class, 'toagentnew'])->name('agents.new');
    Route::delete('agent-delete/{id}', [AgentsManagementController::class, 'AgentDelete'])->name('agent-delete');
    Route::get('/agent/view/{slug}', [AgentsManagementController::class, 'toagentview'])->name('agent.view');
    Route::POST('agent-save', [AgentsManagementController::class, 'AgentSave'])->name('agent-save');
    Route::get('/download/agents', [AdminController::class, 'downloadAgents'])->name('download.agents');

    Route::get('/agent/show/{slug}', [AgentsManagementController::class, 'toagentshow'])->name('agent.show');
    Route::post('/profile', [AgentsManagementController::class, 'toAgentprofileUpdate'])->name('profile.update');
    Route::post('/update-password', [AgentsManagementController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('kyc/update', [AgentsManagementController::class, 'updateKyc'])->name('kyc.update');
    Route::post('bank/update', [AgentsManagementController::class, 'updateBankDetails'])->name('bank.update');
    Route::post('agent/verify', [AgentsManagementController::class, 'toverify'])->name('agent.verify');



    // users
    Route::get('/users', [AdminController::class, 'UserList'])->name('users');
    Route::get('/user/show/{slug}', [AdminController::class, 'tousershow'])->name('users.show');
    Route::delete('user/delete/{id}', [AdminController::class, 'UserDelete'])->name('user.delete');
    Route::get('/user/view/{slug}', [AdminController::class, 'touserview'])->name('user.view');

    Route::post('profile/update', [UsersManagementController::class, 'updateProfile'])->name('profileupdate');
    Route::post('password/update', [UsersManagementController::class, 'updatePassword'])->name('password.update');
    Route::post('kyc/update', [UsersManagementController::class, 'updateKyc'])->name('kyc.update');
    Route::post('bank/update', [UsersManagementController::class, 'updateBankDetails'])->name('bank.update');
    Route::post('user/verify', [UsersManagementController::class, 'toverify'])->name('user.verify');


    Route::get('/subcategories/{categoryId}', [CategoryController::class, 'getSubcategories'])->name('get.subcategories');


    // GetSettings
    Route::get('/settings', [AdminController::class, 'toSettings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'toSettingUpload']);



    //Products
    Route::get('add-product', [ProductController::class, 'AddProduct'])->name('add-product');
    Route::get('products', [ProductController::class, 'Products'])->name('products');
    Route::POST('products', [ProductController::class, 'productSave'])->name('product.save');
    Route::get('product-edit/{id}', [ProductController::class, 'productEdit'])->name('product.edit');
    Route::put('product-update/{id}', [ProductController::class, 'productUpdate'])->name('product.update');
    Route::delete('product/delete/{id}', [ProductController::class, 'productDelete'])->name('product.delete');


    // Orders
    Route::get('orders', [OrderController::class, 'toorders'])->name('orders');
    Route::delete('order/delete/{id}', [OrderController::class, 'toOrderDelete'])->name('order.delete');
    Route::get('order/edit/{id}', [OrderController::class, 'toOrderEdit'])->name('order.edit');
    Route::post('order/update/{id}', [OrderController::class, 'toOrderUpdate'])->name('order.update');
    Route::get('order/invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice');


    Route::get('order/commission/{id}', [InstallmentController::class, 'tocommission'])->name('order.commission');
    Route::post('order/installment', [InstallmentController::class, 'toinstallment'])->name('order.installment');

    Route::post('installment/update',[InstallmentController::class, 'toinstallmentUpdate'])->name('installment.update');




    Route::get('/withdrawls', [WithdrawalController::class, 'topending'])->name('withdraws');
    Route::get('/withdrawl/view/{slug}', [WithdrawalController::class, 'toview'])->name('withdraws.view');
    Route::put('/withdrawl/view/{slug}', [WithdrawalController::class, 'towithdrawalupdate'])->name('withdrawal.update');


    // Categories
    Route::get('/categories', [CategoryController::class, 'toCategories'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'toCategoriesAdd']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'toCategoriesdelete'])->name('category.destroy');
    Route::post('/category/update', [CategoryController::class, 'toCategoriesUpdate'])->name('category.update');


    // Custom Pages
    Route::get('/custom-pages', [AdminController::class, 'toCustom'])->name('custom-page-all');
    Route::get('/custom-pages/create', [AdminController::class, 'toCustomPage'])->name('custom-page');
    Route::post('/custom-pages/create', [AdminController::class, 'toCustomPageSave']);
    Route::get('/custom-pages/update/{id}', [AdminController::class, 'toCustomPageEdit'])->name('custom-page-edit');
    Route::put('/custom-pages/update/{id}', [AdminController::class, 'toCustomPageUpdate'])->name('custom-page-update');
    Route::delete('custom-pages/delete/{id}', [AdminController::class, 'toCustomPageDelete'])->name('custom-page.delete');

    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');

    // Upload
    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy1');
});
