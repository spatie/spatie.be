<?php

use App\Http\Controllers\Api\InstagramPhotosController;
use App\Http\Front\Controllers\DocsController;
use App\Http\Front\Controllers\GithubSocialiteController;
use App\Http\Auth\Controllers\LogoutController;
use App\Http\Front\Controllers\OpenSourceController;
use App\Http\Front\Controllers\PostcardController;
use App\Http\Front\Controllers\Videos\ShowVideoController;
use App\Http\Front\Controllers\Videos\VideoIndexController;
use Illuminate\Support\Facades\Route;

Route::redirect('login', '/nova/login')->name('login');

Route::mailcoach('mailcoach');

Route::view('/', 'front.pages.home.index')->name('home');

Route::post('api/satis/authenticate', fn () => 'ok');

Route::view('web-development', 'front.pages.web-development.index')->name('web-development');

Route::prefix('about-us')->group(function () {
    Route::view('/', 'front.pages.about.index')->name('about');

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

    Route::view('/', 'front.pages.vacancies.index')->name('vacancies.index');
    Route::view('internships', 'front.pages.vacancies.internship')->name('vacancies.internship');

    Route::get('{slug}', function ($slug) {
        $view = "front.pages.vacancies.{$slug}";

        if (! view()->exists($view)) {
            abort(404);
        }

        return view("front.pages.vacancies.{$slug}");
    })->name('vacancies.show');
});

Route::get('login/github', [GithubSocialiteController::class, 'redirect']);
Route::get('login/github/callback', [GithubSocialiteController::class, 'callback']);
Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/videos', VideoIndexController::class)->name('videos.index');
Route::get('/videos/{series:slug}/{video:slug}', ShowVideoController::class)->name('videos.show');

Route::get('/docs/{documentationPage}', DocsController::class)->where('documentationPage', '.*');

Route::view('legal', 'front.pages.legal.index')->name('legal.index');
Route::view('privacy', 'front.pages.legal.privacy')->name('legal.privacy');
Route::view('disclaimer', 'front.pages.legal.disclaimer')->name('legal.disclaimer');
Route::view('general-conditions', 'front.pages.legal.generalConditions')->name('legal.conditions');
Route::view('gdpr', 'front.pages.legal.gdpr')->name('legal.gdpr');

Route::view('offline', 'errors.offline')->name('offline');
