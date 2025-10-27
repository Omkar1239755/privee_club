<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,UserController,HomeController,ProfileController};

// unauthorised routes
Route::post('register-user',[AuthController::class,'registerUSer']);
Route::post('login',[AuthController::class,'Login']);
Route::post('send-otp',[AuthController::class,'sendOtp']);
Route::post('verify-otp',[AuthController::class,'verifyOtp']);
Route::post('reset-otp',[AuthController::class,'resetPassword']);
Route::get('privicy-policy',[AuthController::class,'getPrivicy']);
Route::get('term-condition',[AuthController::class,'terms']);

    
// authorised routes
Route::group(['middleware'=>'auth:sanctum'],function(){
Route::post('logout',[AuthController::class,'logout'])->name('logout');  


Route::get('home-data',[HomeController::class,'home'])->name('home');
Route::post('home-data-list',[HomeController::class,'homeList']);
Route::post('view-detail',[HomeController::class,'viewDetail']);
Route::post('user-rating',[HomeController::class,'userRate']);
Route::post('user-story',[HomeController::class,'userStory']);
Route::post('user-story-status',[HomeController::class,'updateStoryStatus']);
Route::post('user-story-delete',[HomeController::class,'updateStoryDelete']);

// IMAGE FOR VERIFICATION
Route::post('profile-image',[UserController::class,'profileImage'])->name('profileimage');
// add single user-BEST-image
Route::post('user-image',[UserController::class,'userImage'])->name('userImage');
//add gallery-image
Route::post('add-gallery-images',[UserController::class,'galleryImages'])->name('galleryImage');
Route::post('user-gender',[UserController::class,'gender'])->name('userGender');
Route::post('hear-about-us',[UserController::class,'hearAboutUS']);
Route::post('looking-for',[UserController::class,'lookingFor']);
Route::post('additional-detail',[UserController::class,'additionalDetail'])->name('additionalDetail');
Route::post('intrested-in',[UserController::class,'userIntrest']);
Route::post('request-private-access',[UserController::class,'requestPrivateAccess']);
Route::post('request-list',[UserController::class,'requestList']);
Route::post('accept-request',[UserController::class,'acceptRequest']);
Route::post('like-user',[UserController::class,'likeUser']);
Route::get('like-user-list',[UserController::class,'likeUserList']);
Route::post('add-to-favourite',[UserController::class,'addFavourite']);



Route::post('profile-detail',[ProfileController::class,'profileDetail']);
// ADD PRIVATE IMAGE 
Route::post('add-private-photo',[ProfileController::class,'privatePhoto']);
Route::post('edit-profile-image',[ProfileController::class,'editProfileImage']);
Route::post('edit-account-detail',[ProfileController::class,'editAccount']);
Route::post('edit-about',[ProfileController::class,'editAbout']);
Route::post('edit-perfect-match',[ProfileController::class,'editAboutMatch']);
Route::post('edit-personall-info',[ProfileController::class,'editPersonallInfo']);
Route::post('edit-lookingfor',[ProfileController::class,'editLookingFor']);
Route::post('delete-user-image',[ProfileController::class,'deleteUserImage']);
Route::get('admin-status',[ProfileController::class,'adminStatus']);
Route::get('profile-timer',[ProfileController::class,'profileTimer']);
Route::post('online-status',[ProfileController::class,'onlineStatus']);






});


// listing from admin side
Route::get('hear-about-us-listing', [UserController::class, 'hearAboutUsListing']);
Route::get('get-LookingFor-listing',[UserController::class,'getLookingFor']);
Route::get('country-code',[UserController::class,'countryCode']);
Route::get('get-nationality',[UserController::class,'Nationality']);
Route::get('get-region',[UserController::class,'getRegion']);
Route::post('get-cityById',[UserController::class,'getCity']);
Route::get('get-bodytype',[UserController::class,'bodyType']);
Route::get('get-sexOrientation',[UserController::class,'sexOrientation']);
Route::get('get-zodiacSign',[UserController::class,'zodiacSign']);

