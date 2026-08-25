<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContentResourceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('throttle:admin-login')
            ->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/content/{resource}', [ContentResourceController::class, 'index'])
            ->where('resource', 'pages|services|posts|projects|jobs')
            ->name('content.index');
        Route::get('/content/{resource}/create', [ContentResourceController::class, 'create'])
            ->where('resource', 'pages|services|posts|projects|jobs')
            ->name('content.create');
        Route::post('/content/{resource}', [ContentResourceController::class, 'store'])
            ->where('resource', 'pages|services|posts|projects|jobs')
            ->name('content.store');
        Route::get('/content/{resource}/{item}/edit', [ContentResourceController::class, 'edit'])
            ->where('resource', 'pages|services|posts|projects|jobs')
            ->whereNumber('item')
            ->name('content.edit');
        Route::put('/content/{resource}/{item}', [ContentResourceController::class, 'update'])
            ->where('resource', 'pages|services|posts|projects|jobs')
            ->whereNumber('item')
            ->name('content.update');
        Route::delete('/content/{resource}/{item}', [ContentResourceController::class, 'destroy'])
            ->where('resource', 'pages|services|posts|projects|jobs')
            ->whereNumber('item')
            ->name('content.destroy');

        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::patch('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');

        Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('job-applications.index');
        Route::get('/job-applications/{jobApplication}', [JobApplicationController::class, 'show'])->name('job-applications.show');
        Route::patch('/job-applications/{jobApplication}', [JobApplicationController::class, 'update'])->name('job-applications.update');
        Route::delete('/job-applications/{jobApplication}', [JobApplicationController::class, 'destroy'])->name('job-applications.destroy');

        Route::get('/categories/{type}', [CategoryController::class, 'index'])
            ->where('type', 'services|posts')->name('categories.index');
        Route::post('/categories/{type}', [CategoryController::class, 'store'])
            ->where('type', 'services|posts')->name('categories.store');
        Route::delete('/categories/{type}/{category}', [CategoryController::class, 'destroy'])
            ->where('type', 'services|posts')->whereNumber('category')->name('categories.destroy');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/redirects', [RedirectController::class, 'index'])->name('redirects.index');
        Route::post('/redirects', [RedirectController::class, 'store'])->name('redirects.store');
        Route::put('/redirects/{redirect}', [RedirectController::class, 'update'])->name('redirects.update');
        Route::delete('/redirects/{redirect}', [RedirectController::class, 'destroy'])->name('redirects.destroy');

        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::post('/media', [MediaController::class, 'store'])->middleware('throttle:10,1')->name('media.store');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
        Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
        Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('/menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
        Route::delete('/menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');
    });
});
