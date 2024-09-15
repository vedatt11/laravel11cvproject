<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CareerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ReferenceController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['prefix'=> 'auth','as'=>'auth.'],routes: function(){
    Route::post('login',[UserController::class,'login']);
    Route::post('register',[UserController::class,'register']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware(['auth:sanctum','is_admin']);
    Route::post('forgot-password',[UserController::class,'sendResetLinkEmail']);
    Route::post('reset-password',[UserController::class,'resetPassword']);


});
Route::group(['middleware'=> ['auth:sanctum','is_admin']],function(){

Route::get('/about',[AboutController::class,'index']);
Route::post('/about/update',[AboutController::class,'update']);

Route::get('/contact',[ContactController::class,'index']);
Route::post('/contact/store',[ContactController::class,'store']);
Route::post('/contact/mail/send',[ContactController::class,'mailSend']);


Route::get('/careers',[CareerController::class,'index']);
Route::post('/career/store',[CareerController::class,'store']);
Route::post('/career/{id}/update',[CareerController::class,'update']);


Route::get('/tags',[TagController::class,'index']);
Route::post('/tags/store',[TagController::class,'store']);
Route::post('/tags/{id}/update',[TagController::class,'update']);
Route::get(uri: '/tags/{id}/tagdetail',action: [TagController::class,'tagdetail']);


Route::get('/category',action: [CategoryController::class,'index']);
Route::post('/category/store',[CategoryController::class,'store']);
Route::post('/category/{id}/update',[CategoryController::class,'update']);


Route::get('/blog',action: [BlogController::class,'index']);
Route::post('/blog/store',[BlogController::class,'store']);
Route::post('/blog/{id}/update',[BlogController::class,'update']);
Route::get(uri: '/blog/{id}/blogdetail',action: [BlogController::class,'blogdetail']);


Route::get('/referances',[ReferenceController::class,'index']);
Route::post('/referances/store',[ReferenceController::class,'store']);
Route::post('/referances/{id}/update',[ReferenceController::class,'update']);
Route::get(uri: '/referances/{id}/referancedetail',action: [ReferenceController::class,'referencedetail']);


Route::get('/project',[ProjectController::class,'index']);
Route::post('/project/store',[ProjectController::class,'store']);
Route::post('/project/{id}/update',[ProjectController::class,'update']);
Route::get(uri: '/project/{id}/projectdetail',action: [ProjectController::class,'projectdetail']);

});
