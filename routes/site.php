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
    Route::get('/settings',[\App\Http\Controllers\site\SettingController::class,'index'])->name('site.settings');
    Route::post('/settings/update',[\App\Http\Controllers\site\SettingController::class,'update'])->name('site.settings_update');
    Route::get('/gallery',[\App\Http\Controllers\site\GalleryController::class,'index'])->name('site.gallery');
    Route::get('/language',[\App\Http\Controllers\site\LanguageController::class,'index'])->name('site.language');
    Route::get('/language/create',[\App\Http\Controllers\site\LanguageController::class,'create'])->name('site.language_create');
    Route::get('/language/constants',[\App\Http\Controllers\site\LanguageController::class,'const_list'])->name('site.language_const');
});
