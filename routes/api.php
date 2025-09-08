<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,UserController};

// unauthorised routes
Route::post('register-user',[AuthController::class,'registerUSer']);
Route::post('login',[AuthController::class,'Login']);



// authorised routes
Route::group(['middleware'=>'auth:sanctum'],function(){
Route::post('logout',[AuthController::class,'logout'])->name('logout');   

Route::post('verification-image',[UserController::class,'verificationImage'])->name('verifyUserImage');
Route::post('profile-image',[UserController::class,'profileImage'])->name('profileImage');
Route::post('additional-detail',[UserController::class,'additionalDetail'])->name('additionalDetail');
Route::post('hear-about-us',[UserController::class,'hearAboutUS']);


});
// listing from admin
Route::get('hear-about-us-listing', [UserController::class, 'hearAboutUsListing']);