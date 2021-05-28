<?php

use App\Http\Auth\Controllers\ForgotPasswordController;
use App\Http\Auth\Controllers\LoginController;
use App\Http\Auth\Controllers\LogoutController;
use App\Http\Auth\Controllers\RegisterController;
use App\Http\Auth\Controllers\ResetPasswordController;
use App\Http\Auth\Controllers\UpdatePasswordController;
use App\Http\Controllers\AppleSocialiteController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\DownloadPurchasableController;
use App\Http\Controllers\DownloadRayController;
use App\Http\Controllers\EventSourcingController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ShowReleaseNotesController;
use App\Http\Controllers\GitHubSocialiteController;
use App\Http\Controllers\GuidelinesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\IsValidLicenseController;
use App\Http\Controllers\OpenSourceController;
use App\Http\Controllers\PostcardController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AfterPaddleSaleController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\RedirectDocsDomainController;
use App\Http\Controllers\RedirectGitHubAdClickController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsesController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::mailcoach('mailcoach');

Route::feeds();

Route::redirect('/docs/products/ray', '/docs/ray');

Route::post('paddle/webhook', WebhookController::class);

Route::get('is-valid-license/{license}', IsValidLicenseController::class);

Route::domain('docs.spatie.be')->group(function () {
    Route::get('/{url}', RedirectDocsDomainController::class)->where('url', '.*');
});

Route::domain('guidelines.spatie.be')->group(function () {
    Route::permanentRedirect('{url?}', 'https://spatie.be/guidelines');
});

Route::view('/', 'front.pages.home.index')->name('home');

Route::view('web-development', 'front.pages.web-development.index')->name('web-development');

Route::prefix('about-us')->group(function () {
    Route::view('/', 'front.pages.about.index')->name('about');

    collect(config('team.members'))->each(function (string $personName) {
        Route::permanentRedirect($personName, "/about-us/#{$personName}");
    });
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('{product:slug}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('{product:slug}/buy/{purchasable}/{license?}', [ProductsController::class, 'buy'])->name('products.buy');

    Route::get('ray/download/{platform}/latest', DownloadRayController::class);

    Route::get('{product:slug}/purchasables/{purchasable}/purchase-complete', AfterPaddleSaleController::class);

    Route::get('{product:slug}/purchases/{purchase}/download/{file}', DownloadPurchasableController::class)
        ->middleware(['auth', 'signed'])
        ->name('purchase.download');

    Route::get('{product:slug}/release-notes', ShowReleaseNotesController::class)->name('product.releaseNotes');
});

Route::prefix('open-source')->group(function () {
    Route::get('/', [OpenSourceController::class, 'packages'])->name('open-source.packages');
    Route::get('projects', [OpenSourceController::class, 'projects'])->name('open-source.projects');
    Route::get('postcards', [PostcardController::class, 'index'])->name('open-source.postcards');
    Route::get('support-us', [OpenSourceController::class, 'support'])->name('open-source.support');
    Route::get('testimonials', [OpenSourceController::class, 'testimonials'])->name('open-source.testimonials');
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

        return view($view);
    })->name('vacancies.show');
});

Route::group(['middleware' => 'auth', 'prefix' => 'profile'], function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile');
    Route::put('/', [ProfileController::class, 'update'])->name('profile');
    Route::get('disconnect', [ProfileController::class, 'disconnect'])->name('github-disconnect');
    Route::get('disconnect-apple', [ProfileController::class, 'disconnectApple'])->name('apple-disconnect');
    Route::delete('/', [ProfileController::class, 'delete'])->name('profile');

    Route::get('password', [UpdatePasswordController::class, 'show'])->name('profile.password');
    Route::put('password', [UpdatePasswordController::class, 'update'])->name('profile.password');

    Route::get('purchases', PurchasesController::class)->name('purchases');
    Route::get('invoices', InvoicesController::class)->name('invoices');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('login/github', [GitHubSocialiteController::class, 'redirect'])->name('github-login');
Route::get('login/github/callback', [GitHubSocialiteController::class, 'callback']);

Route::get('login/apple', [AppleSocialiteController::class, 'redirect'])->name('apple-login');
Route::post('login/apple', [AppleSocialiteController::class, 'callback']);

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');
Route::get('/videos/{series:slug}', [SeriesController::class, 'show'])->name('series.show');
Route::get('/videos/{series:slug}/{video:slug}', [VideosController::class, 'show'])->name('videos.show');

Route::get('/docs', [DocsController::class, 'index'])->name('docs');
Route::get('/docs/{repository}/{alias?}', [DocsController::class, 'repository']);
Route::get('/docs/{repository}/{alias}/{slug}', [DocsController::class, 'show'])->where('slug', '.*');

Route::get('/guidelines', [GuidelinesController::class, 'index'])->name('guidelines');
Route::get('/guidelines/{page}', [GuidelinesController::class, 'show']);

Route::get('/blog', [BlogsController::class, 'index'])->name('blog');
Route::get('/blog/music', MusicController::class)->name('music');

Route::view('legal', 'front.pages.legal.index')->name('legal.index');
Route::view('privacy', 'front.pages.legal.privacy')->name('legal.privacy');
Route::view('disclaimer', 'front.pages.legal.disclaimer')->name('legal.disclaimer');
Route::view('general-conditions', 'front.pages.legal.generalConditions')->name('legal.conditions');
Route::view('gdpr', 'front.pages.legal.gdpr')->name('legal.gdpr');

Route::get('github-ad-click/{repositoryName}', RedirectGitHubAdClickController::class)->name('github-ad-click');

Route::view('offline', 'errors.offline')->name('offline');

Route::get('event-sourcing', [EventSourcingController::class, 'show']);
Route::post('event-sourcing', [EventSourcingController::class, 'subscribe']);

Route::get('uses', [UsesController::class, 'index'])->name('uses');

