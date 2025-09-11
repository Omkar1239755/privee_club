<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,UserController,HomeController};

// unauthorised routes
Route::post('register-user',[AuthController::class,'registerUSer']);
Route::post('login',[AuthController::class,'Login']);



// authorised routes
Route::group(['middleware'=>'auth:sanctum'],function(){
Route::post('logout',[AuthController::class,'logout'])->name('logout');   

Route::post('profile-image',[UserController::class,'profileImage'])->name('profileimage');
Route::post('user-image',[UserController::class,'userImage'])->name('userImage');
Route::post('additional-detail',[UserController::class,'additionalDetail'])->name('additionalDetail');
Route::post('hear-about-us',[UserController::class,'hearAboutUS']);
Route::post('looking-for',[UserController::class,'lookingFor']);


Route::get('home-data',[HomeController::class,'home'])->name('home');
Route::post('view-detail',[HomeController::class,'viewDetail']);



});
// listing from admin
Route::get('hear-about-us-listing', [UserController::class, 'hearAboutUsListing']);
Route::get('get-LookingFor-listing',[UserController::class,'getLookingFor']);
