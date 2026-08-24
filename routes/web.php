<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LegacyRedirectController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\RecruitmentController;
use App\Http\Controllers\Frontend\RobotsController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [PageController::class, 'about'])->name('about');
Route::get('/trang/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/dich-vu', [ServiceController::class, 'index'])->name('services.index');
Route::get('/dich-vu/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/tin-tuc', [PostController::class, 'index'])->name('posts.index');
Route::get('/tin-tuc/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/du-an', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/du-an/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/tuyen-dung', [RecruitmentController::class, 'index'])->name('recruitment.index');
Route::get('/tuyen-dung/{slug}', [RecruitmentController::class, 'show'])->name('recruitment.show');
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->middleware('throttle:contact-form')->name('contact.store');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/tim-kiem', SearchController::class)->name('search');

Route::fallback(LegacyRedirectController::class);
