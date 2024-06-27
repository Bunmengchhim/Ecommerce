<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 



Route::get('/',[FrontendController::class, 'index']);
Route::get('/collections',[FrontendController::class, 'categories']);
Route::get('/collections/{category_slug}',[FrontendController::class, 'products']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth','isAdmin')->group(function (){
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class,'index']);
    
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
        Route::get('create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.create');
        Route::post('/', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.store');
        Route::get('{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');
        Route::put('{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.update');
        Route::delete('bulk-delete', [App\Http\Controllers\Admin\CategoryController::class, 'bulkDestroy']);
    });
    Route::resource('category', CategoryController::class);
    

    Route::group(['prefix' => 'brand'], function () {
        Route::get('/', [App\Http\Controllers\Admin\BrandController::class, 'index']);
        Route::get('create', [App\Http\Controllers\Admin\BrandController::class, 'create'])->name('brand.create');
        Route::post('/', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('brand.store');
        Route::get('{id}/edit', [App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('brand.edit');
        Route::put('{id}', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('brand.update');
        Route::delete('bulk-delete', [App\Http\Controllers\Admin\BrandController::class, 'bulkDestroy']);
    });
    Route::resource('brand', BrandController::class);

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');  
        Route::get('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::get('{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::delete('{product}/image/{image}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
        Route::put('{productId}/color/{colorId}', [ProductController::class, 'updateColorQuantity'])->name('product.updateColorQuantity');
        Route::delete('{productId}/color/{colorId}', [ProductController::class, 'deleteColor'])->name('product.deleteColor');

        
    });



    Route::group(['prefix' => 'color'], function () {
        Route::get('/', [App\Http\Controllers\Admin\ColorController::class, 'index']);
        Route::get('create', [App\Http\Controllers\Admin\ColorController::class, 'create'])->name('color.create');
        Route::post('/', [App\Http\Controllers\Admin\ColorController::class, 'store'])->name('color.store');
        Route::get('{id}/edit', [App\Http\Controllers\Admin\ColorController::class, 'edit'])->name('color.edit');
        Route::put('{id}', [App\Http\Controllers\Admin\ColorController::class, 'update'])->name('color.update');
        Route::delete('bulk-delete', [App\Http\Controllers\Admin\ColorController::class, 'bulkDestroy']);
    });
    Route::resource('color', ColorController::class);
    
    
    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', [App\Http\Controllers\Admin\SliderController::class, 'index']);
        Route::get('create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('slider.create');
        Route::post('/', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('slider.store');
        Route::get('{id}/edit', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('slider.edit');
        Route::put('{id}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('slider.update');
        Route::delete('bulk-delete', [App\Http\Controllers\Admin\SliderController::class, 'bulkDestroy']);
    });
    Route::resource('slider', SliderController::class);
    
    





});