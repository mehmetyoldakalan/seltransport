<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('site')->middleware(['auth','isSite'])->group(function(){
    Route::get('/',[\App\Http\Controllers\site\HomeController::class,'index'])->name('site.index');
    Route::get('/content',[\App\Http\Controllers\site\ContentController::class,'index'])->name('site.content');
});
