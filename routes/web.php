<?php

use App\Http\Controllers\Admin\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Route::get('/blog', [\App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('blog');
Route::get('/blog-details/{id}', [\App\Http\Controllers\Frontend\BlogController::class, 'details'])->name('blog-details');

Route::get('/contact', function () {
    return view('frontend.contact');
})->name('contact');

Route::get('/agency', [\App\Http\Controllers\Frontend\AgencyTourController::class, 'index'])->name('agency');
Route::get('/agency-details/{id}', [\App\Http\Controllers\Frontend\AgencyTourController::class, 'details'])->name('agency-details');
Route::post('/tour-booking/store', [\App\Http\Controllers\Frontend\TourBookingController::class, 'store'])->name('tour-booking.store');
Route::get('/booking-list/{agencyId}', [\App\Http\Controllers\Frontend\TourBookingController::class, 'index'])->name('tour-booking.list');

Route::get('/recommendation', [\App\Http\Controllers\Frontend\RecommendationController::class, 'index'])->name('recommendation');

Route::get('/recommendation/details/{id}', [\App\Http\Controllers\Frontend\RecommendationController::class, 'details'])->name('recommendation.details');
Route::post('/tour/request', [\App\Http\Controllers\Frontend\RecommendationController::class, 'request'])->name('tour.request');

Route::get('/package-details', function () {
    return view('frontend.package-details');
})->name('package-details');

Route::get('/profile', function () {
    return view('frontend.admin.dashboard');
})->middleware('auth')->name('profile');


Route::resource('blogs', BlogController::class)->middleware('auth');
Route::resource('tours', \App\Http\Controllers\Admin\TourController::class)->middleware('auth');
Route::resource('agency-tours', \App\Http\Controllers\Admin\AgencyTourController::class)->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
