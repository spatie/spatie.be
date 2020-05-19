<?php

use App\Http\Controllers\Api\InstagramPhotosController;
use App\Http\Controllers\GithubSocialiteController;
use App\Http\Controllers\OpenSourceController;
use App\Http\Controllers\PostcardController;
use App\Http\Controllers\Videos\ShowVideoController;
use App\Http\Controllers\Videos\VideoIndexController;
use Spatie\Cors\Cors;

Route::view('/', 'pages/home/index')->name('home');


Route::view('web-development', 'pages/web-development/index')->name('web-development');

Route::prefix('about-us')->group(function () {
    Route::view('/', 'pages/about/index')->name('about');

    collect(config('team.members'))->each(function (string $personName) {
        Route::permanentRedirect($personName, "/about-us/#{$personName}");
    });
});

Route::prefix('open-source')->group(function () {
    Route::get('/', [OpenSourceController::class, 'index'])->name('open-source.index');
    Route::get('postcards', [PostcardController::class, 'index'])->name('open-source.postcards');
    Route::get('packages', [OpenSourceController::class, 'packages'])->name('open-source.packages');
    Route::get('projects', [OpenSourceController::class, 'projects'])->name('open-source.projects');
    Route::get('support-us', [OpenSourceController::class, 'support'])->name('open-source.support');
});

Route::prefix('vacancies')->group(function () {
    Route::permanentRedirect('free-application', '/vacancies/spontaneous-application');

    Route::view('/', 'pages.vacancies.index')->name('vacancies.index');
    Route::view('internships', 'pages.vacancies.internship')->name('vacancies.internship');

    Route::get('{slug}', function ($slug) {
        $view = "pages.vacancies.{$slug}";

        if (! view()->exists($view)) {
            abort(404);
        }

        return view("pages.vacancies.{$slug}");
    })->name('vacancies.show');
});

// Github login
Route::get('login/github', [GithubSocialiteController::class, 'redirect']);
Route::get('login/github/callback', [GithubSocialiteController::class, 'callback']);

// Videos
Route::get('/videos', VideoIndexController::class)->name('videos.index');
Route::get('/videos/{series:slug}/{video:slug}', ShowVideoController::class)->name('videos.show');

Route::get('api/instagram-photos', InstagramPhotosController::class)->middleware(Cors::class);

Route::view('legal', 'pages.legal.index')->name('legal.index');
Route::view('privacy', 'pages.legal.privacy')->name('legal.privacy');
Route::view('disclaimer', 'pages.legal.disclaimer')->name('legal.disclaimer');
Route::view('general-conditions', 'pages.legal.generalConditions')->name('legal.conditions');
Route::view('gdpr', 'pages.legal.gdpr')->name('legal.gdpr');

Route::view('offline', 'errors.offline')->name('offline');
