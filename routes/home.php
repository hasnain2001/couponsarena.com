<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\Localization;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\HomeController;


     Route::middleware([Localization::class])->group(function () {
        Route::group(['prefix' => '{lang}',], function () {
        Route::get('/contact', function () {return view('front-end.contact');})->name('contact');
        Route::get('/about', function () {return view('front-end.about');})->name('about');
        Route::get('/terms-and-condition', function () {return view('front-end.terms_and_condition');})->name('terms_and_condition');
        Route::get('/privacy', function () {return view('front-end.privacy');})->name('privacy');
        Route::get('/cookies', function () {return view('front-end.cookies');})->name('cookies');
        Route::get('/imprint', function () {return view('front-end.imprint');})->name('imprint');
        });
    });
    Route::middleware([Localization::class])->group(function () {
        Route::controller(HomeController::class)->group(function () {
        Route::get('/{lang?}', 'index')->name('home');
        Route::get('/{lang}/store', 'stores')->name('store');
        Route::get('store/{slug}', function($slug) {return app(HomeController::class)->StoreDetails('en', $slug, request());})->name('store_details');
        Route::get('/{lang}/store/{slug}', [HomeController::class, 'StoreDetails'])->name('store_details.withLang');
        Route::get('/category/{slug}', [HomeController::class, 'viewcategory'])->name('category.details');

        Route::get('/{lang}/blog', 'blog')->name('blog');
        Route::get('/blog/{slug}',function($slug) {return app(HomeController::class)->blog_detail('en', $slug, request());})->name('blog-details');
        Route::get('/{lang}/blog/{slug}', 'blog_detail')->name('blog-details.withLang');
        Route::get('/{lang}/coupons','coupons')->name('coupons');

        });
    });

    // Route for search
    Route::get('/category', [HomeController::class,'categories'])->name('categories');

    Route::put('/updateCoupon/{id}', [CouponsController::class, 'updatecoupon'])->name('updateCoupon');
    Route::post('/update-clicks', [CouponsController::class, 'updateClicks'])->name('update.clicks');
    Route::get('/clicks/{couponId}', [CouponsController::class, 'openCoupon'])->name('open.coupon');
    Route::post('/coupons', [CouponsController::class, ''])->name('coupons.updateRanking');


    Route::get('/stores/search', [SearchController::class, 'searchResults'])->name('storesearch');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search_results', [SearchController::class, 'searchResults'])->name('search_results');

