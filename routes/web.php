<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.project')->name('page.project');
Route::view('/lage', 'pages.location')->name('page.location');
Route::get('/gewerbe', [OfferController::class, 'commercial'])->name('page.commercial');
Route::get('/wohnungen', [OfferController::class, 'living'])->name('page.living');
Route::view('/kontakt', 'pages.contact')->name('page.contact');

Route::view('/impressum', 'pages.imprint')->name('page.imprint');
Route::view('/datenschutz', 'pages.privacy')->name('page.privacy');
