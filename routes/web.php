<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.project')->name('page.project');
Route::view('/lage', 'pages.location')->name('page.location');
Route::get('/gewerbe', [OfferController::class, 'commercial'])->name('page.commercial');
Route::get('/wohnungen', [OfferController::class, 'living'])->name('page.living');
Route::view('/kontakt', 'pages.contact')->name('page.contact');
Route::view('/danke', 'pages.thanks')->name('page.thanks');

Route::view('/impressum', 'pages.imprint')->name('page.imprint');
Route::view('/datenschutz', 'pages.privacy')->name('page.privacy');

// robots.txt kommt aus der App statt als statische Datei, damit Staging per
// ROBOTS_NOINDEX=true gesperrt bleibt und ein Deploy das nicht zuruecksetzt.
Route::get('/robots.txt', function () {
    $body = config('seo.noindex')
        ? "User-agent: *\nDisallow: /\n"
        : "User-agent: *\nDisallow:\n";

    return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->name('robots');
