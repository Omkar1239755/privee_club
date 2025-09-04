<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\{AdminController,DashboardController};

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');

    return 'Cleared!';
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class)->names('admin');
});


Route::match(['get', 'post'], '/administrator', [AdminController::class, 'adminLogin'])->name('admin.login');


Route::prefix('admin')->name('admin.')->group(function () {
Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

});
