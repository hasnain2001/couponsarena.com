<?php
use App\Http\Controllers\Employee\BlogController;
use App\Http\Controllers\Employee\StoresController;
use App\Http\Controllers\Employee\CouponsController;
use App\Http\Controllers\Employee\NetworksController;
use App\Http\Controllers\Employee\CategoriesController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\SearchController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
Route::middleware([RoleMiddleware::class])->group(function () {
    
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
        });
     // Employee Routes Begin
      Route::controller(BlogController::class)->prefix('employee')->name('employee.blog.')->group(function () {
          Route::get('/blog',  'index')->name('index');
          Route::get('/blog/create',  'create')->name('create');
          Route::post('/blog/store', 'store')->name('store');
          Route::get('/blog/{id}/edit', 'edit')->name('edit');
          Route::post('/blog/update/{id}', 'update')->name('update');
          Route::delete('/blog/{id}', 'destroy')->name('delete');
          Route::post('/blog/deleteSelected', 'deleteSelected')->name('deleteSelected');
          Route::delete('/blog/bulk-delete', 'deleteSelected')->name('bulkDelete');
      });

      // Stores Routes Begin
      Route::controller(StoresController::class)->prefix('employee')->name('employee.store.')->group(function () {
          Route::get('/store', 'store')->name('index');
          Route::get('/Store/Create', 'create_store')->name('create');
          Route::post('/store/stores', 'store_store')->name('store');
          Route::get('/store/edit/{id}', 'edit_store')->name('edit');
          Route::post('/store/update/{id}', 'update_store')->name('update');
          Route::get('/store/delete/{id}', 'delete_store')->name('delete');
          Route::post('/store/deleteSelected', 'deleteSelected')->name('deleteSelected');
          Route::get('/stores/{slug}', 'StoreDetails')->name('store_details');
          Route::post('/check-slug', 'checkSlug')->name('check.slug');

      });


      // Categories Routes Begin
      Route::controller(CategoriesController::class)->prefix('employee')->name('employee.category.')->group(function () {
          Route::get('/category', 'category')->name('index');
          Route::get('/category/create', 'create_category')->name('create');
          Route::post('/category/store', 'store_category')->name('store');
          Route::get('/category/edit/{id}', 'edit_category')->name('edit');
          Route::post('/category/update/{id}', 'update_category')->name('update');
          Route::get('/category/delete/{id}', 'delete_category')->name('delete');
           Route::post('/category/deleteSelected', 'deleteSelected')->name('deleteSelected');
      });


      // Networks Routes Begin
      Route::controller(NetworksController::class)->prefix('employee')->name('employee.network.')->group(function () {
          Route::get('/network', 'network')->name('index');
          Route::get('/network/create', 'create_network')->name('create');
          Route::post('/network/store', 'store_network')->name('store');
          Route::get('/network/edit/{id}', 'edit_network')->name('edit');
          Route::post('/network/update/{id}', 'update_network')->name('update');
          Route::get('/network/delete/{id}', 'delete_network')->name('delete');
      });
   // Networks Routes Begin
      Route::controller(CouponsController::class)->prefix('employee')->name('employee.coupon.')->group(function () {
          Route::get('/coupon', 'coupon')->name('index');
          Route::get('/coupon/create', 'create_coupon')->name('create');
          Route::get('/coupon/create/code', 'create_coupon_code')->name('code');
          Route::post('/coupon/store', 'store_coupon')->name('store');
          Route::get('/coupon/edit/{id}', 'edit_coupon')->name('edit');
          Route::post('/coupon/update/{id}', 'update_coupon')->name('update');
          Route::get('/coupon/delete/{id}', 'delete_coupon')->name('delete');
          Route::post('/custom-sortable', 'update')->name('custom-sortable');
      Route::post('/coupon/deleteSelected', 'deleteSelected')->name('deleteSelected');
  });
    Route::controller(SearchController::class)->prefix('employee')->name('employee.')->group(function () {
        Route::get('/search', 'search')->name('search');
        Route::get('/search_results', 'searchResults')->name('search_results');
        Route::get('/quick-search', 'searchResults')->name('search.quick-results');
        Route::get('/search-suggestions', 'searchSuggestions')->name('search_suggestions');
        Route::get('/quick-search', 'quickSearch')->name('quick_search');
    });
  });
