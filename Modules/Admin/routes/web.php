<?php
use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\{AdminController,DashboardController,CommonController};
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
Route::post('update-adminstatus',[AdminController::class,'updateStatus' ])->name('admin.update');
Route::delete('/user/{id}', [AdminController::class, 'destroy'])->name('destroy');

Route::post('/profile-approval/update', [AdminController::class, 'updateProfileApproval'])->name('profileApproval.update');


Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('logout',[AdminController::class,'logout'])->name('logout');
    Route::get('get-user',[DashboardController::class,'user'])->name('user');
    Route::get('view-user/{id}',[DashboardController::class,'viewUser'])->name('viewuser');
    Route::get('category',[DashboardController::class,'Catgeory'])->name('catgeories');
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard'); 
    Route::get('add-category',[DashboardController::class,'add'])->name('add');
    Route::match(['get', 'post'], 'privacy', [CommonController::class, 'privacy'])->name('privacy');
    Route::match(['get','post'],'term',[CommonController::class,'term'])->name('term');

});
