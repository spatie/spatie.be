<?php

Route::prefix('opensource')->group(function () {
    Route::redirectPermanent('/', '/open-source');
    Route::redirectPermanent('php', '/open-source/packages');
    Route::redirectPermanent('laravel', '/open-source/packages');
    Route::redirectPermanent('javascript', '/open-source/packages');
    Route::redirectPermanent('postcards', '/open-source/postcards');
});

collect(['en', 'nl'])->each(function (string $locale) {
    Route::prefix($locale)->group(function () {
        Route::redirectPermanent('/', '/');

        Route::prefix('opensource')->group(function () {
            Route::redirectPermanent('/', '/open-source');
            Route::redirectPermanent('php', '/open-source/packages');
            Route::redirectPermanent('laravel', '/open-source/packages');
            Route::redirectPermanent('javascript', '/open-source/packages');
            Route::redirectPermanent('postcards', '/open-source/postcards');
        });

        Route::redirectPermanent('team', '/about-us#team');
        Route::redirectPermanent('jef', '/about-us#jef');
        Route::redirectPermanent('vacancies', '/vacancies');
        Route::redirectPermanent('back-end-vacancy', '/vacancies');
        Route::redirectPermanent('front-end-vacancy', '/vacancies');
        Route::redirectPermanent('disclaimer', '/disclaimer');
        Route::redirectPermanent('stage', '/vacancies/internships');
        Route::redirectPermanent('legaal', '/legal');
        Route::redirectPermanent('legal', '/legal');
    });
});

Route::redirectPermanent('jef', '/about-us#jef');
