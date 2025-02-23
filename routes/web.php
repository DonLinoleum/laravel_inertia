<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;

Route::get('/', HomeController::class)->name('login');
Route::inertia("/profile","Profile/Index")->middleware("auth:web")->name("profile");


Route::middleware("auth:web")
->group(function(){
    Route::get("/profile", [ProfileController::class,'index'])
    ->name("profile.index");
    
    Route::post("/profile/update-avatar",[ProfileController::class,'updateAvatar'])
    ->name("profile.avatar-update");

    Route::get('/friends',[FriendController::class,"index"])->name('friends.index');
});