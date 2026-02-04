<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\NetworksController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
// Admin routes


Route::middleware([RoleMiddleware::class])->group(function () {

    Route::controller(AdminController::class)->prefix('admin')->name('admin.')->group(function () {
            // Dashboard Routes
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/dashboard/stats', 'getStats')->name('dashboard.stats');
            Route::get('/dashboard/period/{period}', 'getPeriodStats')->name('dashboard.period');
            Route::get('/dashboard/refresh', 'refreshStats')->name('dashboard.refresh');
            // User Routes
            Route::get('/users', 'index')->name('user.index');
            Route::get('/user/create', 'create_user')->name('user.create');
            Route::post('/user/store', 'store_user')->name('user.store');
            Route::get('/user/edit/{id}', 'edit_user')->name('user.edit');
            Route::post('/user/update/{id}', 'update_user')->name('user.update');
            Route::delete('/users/{id}', 'destroy')->name('user.destroy');
            Route::get('/user/{id}', 'show_user')->name('user.show');
            Route::post('/user/deleteSelected', 'deleteSelected')->name('user.deleteSelected');
            Route::get('/settings', 'settings')->name('settings');
            Route::post('/settings/update', 'update_settings')->name('settings.update');
        });
        // Slider Routes
            Route::controller(SliderController::class)->prefix('admin')->name('admin.')->group(function () {
                Route::get('/slider', 'index')->name('slider.index');
                Route::get('/slider/create', 'create')->name('slider.create');
                Route::post('/slider/store', 'store')->name('slider.store');
                Route::get('/slider/edit/{id}', 'edit')->name('slider.edit');
                Route::post('/slider/update/{id}', 'update')->name('slider.update');
                Route::get('/slider/delete/{id}', 'delete')->name('slider.delete');
            });
        // Delete Routes
        Route::controller(DeleteController::class)->prefix('admin')->name('admin.')->group(function () {
            Route::get('/delete-store', 'deletedStores')->name('delete_store');
            Route::get('/delete-store/delete{id}', 'delete')->name('delete-store-delete');
        });
    // Language Routes Begin
    Route::controller(LanguageController::class)->prefix('admin')->name('admin.lang.')->group(function () {
        Route::get('/lang', 'language')->name('index');
        Route::get('/lang/Create', 'create_language')->name('create');
        Route::post('/lang/stores', 'store_language')->name('store');
        Route::get('/lang/edit/{id}', 'edit_language')->name('edit');
        Route::post('/lang/update/{id}', 'update_language')->name('update');
        Route::get('/lang/delete/{id}', 'delete_language')->name('delete');
        Route::post('/lang/deleteSelected', 'deleteSelected')->name('deleteSelected');
        Route::get('/lang/{slug}', 'StoreDetails')->name('details');
    });

    // Blogs Routes Begin
    Route::controller(BlogController::class)->prefix('admin')->name('admin.blog.')->group(function () {
        Route::get('/blog',  'index')->name('index');
        Route::get('/blog/create',  'create')->name('create');
        Route::post('/blog/store', 'store')->name('store');
        Route::get('/blog/{id}/edit', 'edit')->name('edit');
        Route::put('/admin/blog/update/{id}', 'update')->name('update');
        Route::get('/blog/{id}', 'show')->name('show');
        Route::delete('/blog/{id}', 'destroy')->name('delete');
        Route::post('/blog/deleteSelected', 'deleteSelected')->name('deleteSelected');
        Route::delete('/blog/bulk-delete', 'deleteSelected')->name('bulkDelete');
        Route::post('/blog/create', 'checkSlug')->name('check.slug');
    });

    // Stores Routes Begin
    Route::controller(StoresController::class)->prefix('admin/store')->name('admin.store.')->group(function () {
        Route::get('/', 'store')->name('index');
        Route::get('/Create', 'create_store')->name('create');
        Route::post('/store', 'store_store')->name('store');
        Route::get('/edit/{id}', 'edit_store')->name('edit');
        Route::post('/update/{id}', 'update_store')->name('update');
        Route::get('/delete/{id}', 'delete_store')->name('delete');
        Route::post('/deleteSelected', 'deleteSelected')->name('deleteSelected');
        Route::get('/{slug}', 'StoreDetails')->name('store_details');
        Route::post('/check-slug', 'checkSlug')->name('check.slug');
    });


    // Categories Routes Begin
    Route::controller(CategoriesController::class)->prefix('admin')->name('admin.category.')->group(function () {
        Route::get('/category', 'category')->name('index');
        Route::get('/category/create', 'create_category')->name('create');
        Route::post('/category/store', 'store_category')->name('store');
        Route::get('/category/edit/{id}', 'edit_category')->name('edit');
        Route::post('/category/update/{id}', 'update_category')->name('update');
        Route::get('/category/delete/{id}', 'delete_category')->name('delete');
         Route::post('/category/deleteSelected', 'deleteSelected')->name('deleteSelected');
    });

    // Networks Routes Begin
    Route::controller(NetworksController::class)->prefix('admin')->name('admin.network.')->group(function () {
        Route::get('/network', 'network')->name('index');
        Route::get('/network/create', 'create_network')->name('create');
        Route::post('/network/store', 'store_network')->name('store');
        Route::get('/network/edit/{id}', 'edit_network')->name('edit');
        Route::post('/network/update/{id}', 'update_network')->name('update');
        Route::get('/network/delete/{id}', 'delete_network')->name('delete');
    });

    Route::controller(CouponsController::class)->prefix('admin')->name('admin.coupon.')->group(function () {
        Route::get('/coupon', 'index')->name('index');
        Route::get('/coupon/create', 'create')->name('create');
        Route::post('/coupon/store', 'store')->name('store');
        Route::get('/coupon/edit/{id}', 'edit')->name('edit');
        Route::post('/coupon/update/{id}', 'update')->name('update');
        Route::get('/coupon/delete/{id}', 'delete')->name('delete');
        Route::post('/coupon/deleteSelected', 'deleteSelected')->name('deleteSelected');
        Route::get('/coupon/show/{id}', 'show')->name('show');
        Route::post('/coupon/bulkUpdate', 'bulk_update')->name('bulkUpdate');
        Route::get('/coupon/export', 'export')->name('export');
        Route::get('/store/coupons/{store_id}', 'store_coupons')->name('store.coupons');
        Route::get('/store/{store_id}/coupons', 'storeCoupons')->name('coupon.storeList');
        Route::post('/coupon/reorder', 'update_clicks')->name('reorder');
        Route::post('/coupon/sortable', 'update_clicks')->name('sortable');
    });
    Route::controller(SearchController::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/search', 'search')->name('search');
        Route::get('/search_results', 'searchResults')->name('search_results');
        Route::get('/quick-search', 'searchResults')->name('search.quick-results');
        Route::get('/admin/search-suggestions', 'searchSuggestions')->name('admin.search_suggestions');
        Route::get('/admin/quick-search', 'quickSearch')->name('admin.quick_search');
    });

});
