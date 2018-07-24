<?php

Route::view('/', 'pages/home/index')->name('home');

Route::view('laravel', 'pages/laravel/index')->name('laravel');

Route::view('web-development', 'pages/web-development/index')->name('web-development');

Route::prefix('about-us')->group(function () {
    Route::view('/', 'pages/about/index')->name('about');

    collect(config('team.members'))->each(function (string $personName) {
        Route::redirect($personName, "#{$personName}");
    });
});

Route::prefix('open-source')->group(function () {
    Route::get('/', 'OpensourceController@index')->name('open-source.index');
    Route::get('postcards', 'PostcardController@index')->name('open-source.postcards');
    Route::get('packages', 'OpensourceController@packages')->name('open-source.packages');
    Route::get('projects', 'OpensourceController@projects')->name('open-source.projects');
});

Route::prefix('vacancies')->group(function () {
    Route::view('/', 'pages.vacancies.index')->name('vacancies.index');
    Route::view('internships', 'pages.vacancies.internship')->name('vacancies.internship');

    Route::get('{slug}', function ($slug) {
        return view("pages.vacancies.{$slug}");
    })->name('vacancies.show');
});

Route::view('legal', 'pages.legal.index')->name('legal.index');

Route::view('privacy', 'pages.legal.privacy')->name('legal.privacy');

Route::view('disclaimer', 'pages.legal.disclaimer')->name('legal.disclaimer');

collect(['en', 'nl'])->each(function (string $locale) {
    Route::redirect("{$locale}/", '/');
    Route::redirect("{$locale}/open-source", 'open-source');
    Route::redirect("{$locale}/open-source/php", 'open-source/packages');
    Route::redirect("{$locale}/open-source/laravel", 'open-source/packages');
    Route::redirect("{$locale}/open-source/javascript", 'open-source/packages');
    Route::redirect("{$locale}/open-source/postcards", 'open-source/postcards');

    Route::redirect("{$locale}/team", 'about-us');
    Route::redirect("{$locale}/disclaimer", 'disclaimer');
    Route::redirect("{$locale}/stage", 'vacancies/internships');
});
