<?php

Route::prefix('opensource')->group(function () {
    Route::redirect('/', '/open-source');
    Route::redirect('php', '/open-source/packages');
    Route::redirect('laravel', '/open-source/packages');
    Route::redirect('javascript', '/open-source/packages');
    Route::redirect('postcards', '/open-source/postcards');
});

collect(['en', 'nl'])->each(function (string $locale) {
    Route::prefix($locale)->group(function () {
        Route::redirect('/', '/');

        Route::prefix('opensource')->group(function () {
            Route::redirect('/', '/open-source');
            Route::redirect('php', '/open-source/packages');
            Route::redirect('laravel', '/open-source/packages');
            Route::redirect('javascript', '/open-source/packages');
            Route::redirect('postcards', '/open-source/postcards');
        });

        Route::redirect('team', '/about-us#team');
        Route::redirect('vacancies', '/vacancies');
        Route::redirect('back-end-vacancy', '/vacancies');
        Route::redirect('front-end-vacancy', '/vacancies');
        Route::redirect('disclaimer', '/disclaimer');
        Route::redirect('stage', '/vacancies/internships');
        Route::redirect('legaal', '/legal');
        Route::redirect('legal', '/legal');
    });
});
