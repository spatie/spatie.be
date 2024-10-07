<?php

use App\Http\Auth\Controllers\ForgotPasswordController;
use App\Http\Auth\Controllers\LoginController;
use App\Http\Auth\Controllers\LogoutController;
use App\Http\Auth\Controllers\RegisterController;
use App\Http\Auth\Controllers\ResetPasswordController;
use App\Http\Auth\Controllers\UpdatePasswordController;
use App\Http\Controllers\AfterPaddleBundleSaleController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\BundlesController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\DownloadLatestReleaseForExpiredLicenseController;
use App\Http\Controllers\DownloadPurchasableController;
use App\Http\Controllers\DownloadRayController;
use App\Http\Controllers\ExternalFeedItemsController;
use App\Http\Controllers\InsightsController;
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
use App\Http\Controllers\TidBitsSubscriptionController;
use App\Http\Controllers\UsesController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WwsdController;
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('docs/ray', 'https://myray.app/docs/');
Route::permanentRedirect('docs/ray/{any}', 'https://myray.app/docs/')->where('any', '.*');
Route::permanentRedirect('docs/laravel-medialibrary/v11/handling-uploads-with-media-library-pro{any}', 'https://spatie.be/docs/laravel-medialibrary-pro/v6/introduction')->where('any', '.*');

Route::redirect('/mailcoach/{any}', 'https://spatie.mailcoach.app/{any}')->where('any', '.*');

Route::feeds();

Route::get('insights', [InsightsController::class, 'index'])->name('insights');
Route::get('insights/all', [InsightsController::class, 'all'])->name('insights.all');
Route::get('insights/{slug}', [InsightsController::class, 'detail'])->name('insights.show');
Route::get('team-products', ExternalFeedItemsController::class)->name('external-feed-items');

Route::redirect('/docs/products/ray', '/docs/ray');

Route::post('paddle/webhook', WebhookController::class);

Route::redirect('readable-php', 'https://writing-readable-php.com');

Route::get('is-valid-license/{license}', IsValidLicenseController::class);

Route::get('testing-tidbits/{email}', TidBitsSubscriptionController::class);

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
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('{product:slug}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('{product:slug}/buy/{purchasable}/{license?}', [ProductsController::class, 'buy'])->name('products.buy');

    Route::get('ray/download/{platform}/latest', DownloadRayController::class);

    Route::get('{product:slug}/purchasables/{purchasable}/purchase-complete', AfterPaddleSaleController::class)->name('purchase.complete');

    Route::get('{product:slug}/purchases/{purchase}/download/{file}', DownloadPurchasableController::class)
        ->middleware(['auth', 'signed'])
        ->name('purchase.download');

    Route::get('{product:slug}/release-notes', ShowReleaseNotesController::class)->name('product.releaseNotes');
});

Route::prefix('bundles')->group(function () {
    Route::get('{bundle:slug}', [BundlesController::class, 'show'])->name('bundles.show');
    Route::get('{bundle:slug}/purchase-complete', AfterPaddleBundleSaleController::class);
});

Route::prefix('open-source')->group(function () {
    Route::view('/', 'front.pages.open-source.index')->name('open-source.index');
    Route::view('packages', 'front.pages.open-source.packages')->name('open-source.packages');
    Route::get('postcards', [PostcardController::class, 'index'])->name('open-source.postcards');
});

Route::prefix('vacancies')->group(function () {
    Route::permanentRedirect('free-application', '/vacancies/spontaneous-application');

    Route::view('/', 'front.pages.vacancies.index')->name('vacancies.index');
    Route::view('internships', 'front.pages.vacancies.internship')->name('vacancies.internship');
    Route::redirect('recruiters', "https://youtu.be/cvh0nX08nRw")->name('vacancies.recruiters');

    Route::get('{slug}', function ($slug) {
        $view = "front.pages.vacancies.{$slug}";

        if (! view()->exists($view)) {
            abort(404);
        }

        return view($view);
    })->name('vacancies.show');
});

Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile');
    Route::put('/', [ProfileController::class, 'update'])->name('profile');
    Route::get('disconnect', [ProfileController::class, 'disconnect'])->name('github-disconnect');
    Route::delete('/', [ProfileController::class, 'delete'])->name('profile');

    Route::get('password', [UpdatePasswordController::class, 'show'])->name('profile.password');
    Route::put('password', [UpdatePasswordController::class, 'update'])->name('profile.password');

    Route::get('purchases', PurchasesController::class)->name('purchases');
    Route::get('invoices', InvoicesController::class)->name('invoices');

    Route::get('download-latest-version-for-expired-license/{license}/{repo}', DownloadLatestReleaseForExpiredLicenseController::class)->name('downloadLatestRelease');
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

Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/{series:slug}', [SeriesController::class, 'show'])->name('series.show');
Route::get('/courses/{series:slug}/{lesson:slug}', [CoursesController::class, 'show'])->name('courses.show');
Route::post('/courses/{series:slug}/{lesson:slug}', [CoursesController::class, 'completeLesson'])->name('courses.completeLesson');

Route::redirect('/videos', '/courses');

Route::redirect(
    'docs/laravel-mailcoach/{version}/{slug?}',
    'https://mailcoach.app/docs/{version}/mailcoach/{slug?}',
)->where('slug', '.*');

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

Route::get('wwsd/{slug?}', WwsdController::class)->name('wwsd');
Route::view('black-friday-deals', 'front.pages.black-friday-deals.index');

Route::view('offline', 'errors.offline')->name('offline');

Route::permanentRedirect('testing-laravel', 'https://testing-laravel.com');
Route::permanentRedirect('/markdown', 'https://spatie.be/docs/laravel-comments/v1/livewire-components/using-markdown');

/*
Route::get('testing-laravel', [TestingLaravelController::class, 'show']);
Route::post('testing-laravel', [TestingLaravelController::class, 'subscribe']);
*/

Route::get('uses', [UsesController::class, 'index'])->name('uses');

Route::fallback(function (\Illuminate\Http\Request $request) {
    if ($request->segment(1) === 'videos') {
        $newUrl = Str::replaceFirst('/videos', '/courses', $request->url());

        return redirect()->to($newUrl);
    }

    abort(404);
});
