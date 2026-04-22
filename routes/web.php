<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use Illuminate\Support\Facades\Route;
use Webkul\Core\Http\Middleware\NoCacheMiddleware;

Route::group([
    'middleware' => ['admin', NoCacheMiddleware::class],
    'prefix'     => config('app.admin_url'),
], function () {
    Route::controller(BrandController::class)->prefix('brands')->group(function () {
        Route::get('', 'index')->name('admin.brands.index');
        Route::post('', 'store')->name('admin.brands.store');
        Route::put('{optionId}', 'update')->name('admin.brands.update');
        Route::delete('{optionId}', 'destroy')->name('admin.brands.delete');
    });

    Route::controller(BannerController::class)->prefix('banners')->group(function () {
        Route::get('', 'index')->name('admin.banners.index');
        Route::post('', 'store')->name('admin.banners.store');
        Route::delete('{themeId}', 'destroy')->name('admin.banners.delete');
    });

    Route::get('analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
});
