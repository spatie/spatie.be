<?php

namespace Database\Seeders;

use App\Domain\Shop\Enums\SeriesType;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Models\Enums\LessonDisplayEnum;
use App\Models\HtmlLesson;
use App\Models\Lesson;
use App\Models\Series;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        $upcomingCourseSeries = Series::create([
            'id' => 7,
            'title' => 'Writing Readable PHP',
            'slug' => 'writing-readable-php',
            'description' => 'Learn how to write readable PHP',
            'sort_order' => '0',
            'type' => SeriesType::Html,
        ]);

        $this->createHtmlLessonAndLesson([
            'title' => 'First lesson',
            'markdown' => 'Here is the first lesson',
            'sort_order' => 0,
            'series_id' => $upcomingCourseSeries->id,
            'display' => LessonDisplayEnum::FREE,
        ]);

        $this->createHtmlLessonAndLesson([
            'title' => 'Second lesson',
            'markdown' => 'Here is the second lesson',
            'sort_order' => 1,
            'series_id' => $upcomingCourseSeries->id,
            'display' => LessonDisplayEnum::FREE,
        ]);

        $this->createHtmlLessonAndLesson([
            'chapter' => 'Another chapter',
            'chapter_slug' => Str::slug('Another chapter'),
            'title' => 'Third lesson',
            'markdown' => 'Here is the third lesson',
            'sort_order' => 2,
            'series_id' => $upcomingCourseSeries->id,
            'display' => LessonDisplayEnum::FREE,
        ]);

        $this->createHtmlLessonAndLesson([
            'chapter' => 'Another chapter',
            'title' => 'Fourth lesson',
            'markdown' => 'Here is the fourth lesson',
            'sort_order' => 3,
            'series_id' => $upcomingCourseSeries->id,
            'display' => LessonDisplayEnum::FREE,
        ]);

        $this->createHtmlLessonAndLesson([
            'chapter' => 'Yet Another chapter',
            'chapter_slug' => Str::slug('Another chapter'),
            'title' => 'Fifth lesson',
            'markdown' => 'Here is the fifth lesson',
            'sort_order' => 2,
            'series_id' => $upcomingCourseSeries->id,
            'display' => LessonDisplayEnum::FREE,
        ]);

        $this->createHtmlLessonAndLesson([
            'chapter' => 'Yet Another chapter',
            'title' => 'Sixth lesson',
            'markdown' => 'Here is the sixth lesson',
            'sort_order' => 3,
            'series_id' => $upcomingCourseSeries->id,
            'display' => LessonDisplayEnum::FREE,
        ]);

        Series::create([
            'title' => 'Laravel Package Training',
            'slug' => 'laravel-package-training',
            'description' => 'Have you ever wondered how to create your own packages? Interested in how some of our packages work under the hood? This series reveals all secrets!',
            'sort_order' => '0',
            'type' => SeriesType::Video,
        ]);

        $mailcoach = Series::create([
            'title' => 'Building Mailcoach',
            'slug' => 'building-mailcoach',
            'description' => 'Learn about the problems that we tackled and the clean code patterns that we applied when building the Mailcoach newsletter application.',
            'sort_order' => '1',
            'type' => SeriesType::Video,

        ]);

        Series::create([
            'title' => 'Readable Laravel',
            'slug' => 'readable-laravel',
            'description' => 'In this series, we\'ll explore best practices on how to write maintainable and readable code.',
            'sort_order' => '2',
            'type' => SeriesType::Video,

        ]);
        Series::create([
            'title' => 'Show me the code',
            'slug' => 'show-me-the-code',
            'description' => 'Here are some problems that we solved in an elegant way',
            'sort_order' => '3',
            'type' => SeriesType::Video,
        ]);

        $mailcoachProduct = Product::where('slug', 'mailcoach')->first();
        $mailcoach->purchasables()->attach(Purchasable::where('product_id', $mailcoachProduct->id)->get());

        if (empty(config('services.vimeo.secret'))) {
            return;
        }

        $this->createVideoAndLesson([
            "vimeo_id" => "419946519",
            "description" => "[Our laravel-multitenancy package](https://docs.spatie.be/laravel-multitenancy) can make any Laravel app tenant aware. The philosophy of this package is that it should only provide the bare essentials to enable multitenancy.\n\nIn this video Freek will show how to use the package and how it works under the hood.\n\n## Links\n\n- [laravel-multitenancy docs](https://docs.spatie.be/laravel-multitenancy)\n- [An unopinionated package to make Laravel apps tenant aware](https://freek.dev/1661-an-unopinionated-package-to-make-laravel-apps-tenant-aware)\n- [Mohamed Said's videos on multitenancy](https://www.youtube.com/watch?v=592EgykFOz4)\n- [Tom Schlick's talk on multitenancy at Laracon US 2017](https://www.youtube.com/watch?v=UgWpS4xBiuU)",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "series_id" => 1,
            "title" => "laravel-multitenancy",
            "slug" => "laravel-multitenancy",
            "sort_order" => 0,
            "display" => "license",
        ]);

        $this->createVideoAndLesson([
            "series_id" => 1,
            "vimeo_id" => "420606741",
            "title" => "laravel-responsecache",
            "slug" => "laravel-responsecache",
            "description" => "In this video I walk through [the spatie/laravel-responsecache package](https://github.com/spatie/laravel-responsecache). This one can speed up any Laravel app by caching response. You'll learn how to use it, how it works under the hood, and how it is tested.\n\n## Links\n\n- [spatie/laravel-responsecache](https://github.com/spatie/laravel-responsecache)\n- [Caching the entire response of an app](https://freek.dev/1351-caching-the-entire-response-of-a-laravel-app)\n- [Laravel docs on middleware](https://laravel.com/docs/7.x/middleware)",
            "sort_order" => 1,
            "runtime" => 783,
            "thumbnail" => "https://i.vimeocdn.com/video/895914160_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:45",
        ]);


        $this->createVideoAndLesson([
            "series_id" => 1,
            "vimeo_id" => "423825543",
            "title" => "laravel-dashboard",
            "slug" => "laravel-dashboard",
            "description" => "In this video I demonstrate our laravel-dashboard package. It allows you to easily build realtime dashboards. Behind the scenes Livewire is used.\n\n## Links\n\n- [Laravel Dashboard docs](https://docs.spatie.be/laravel-dashboard/v1/introduction/)\n- [Building a realtime dashboard powered by Laravel, Livewire and Tailwind](https://freek.dev/1645-building-a-realtime-dashboard-powered-by-laravel-livewire-and-tailwind-2020-edition)\n- [Livewire](https://laravel-livewire.com)",
            "sort_order" => 2,
            "runtime" => 1479,
            "thumbnail" => "https://i.vimeocdn.com/video/900440479_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:45",
        ]);

        $this->createVideoAndLesson([
            "series_id" => 1,
            "vimeo_id" => "426741940",
            "title" => "laravel-short-schedule part 1 => Using the package",
            "slug" => "laravel-short-schedule-part-1-using-the-package",
            "description" => "In this three part source we are going to take a look at the spatie/laravel-short-schedule. This package allows you to run Artisan commands at sub-minute intervals. In this first part you'll learn how to use the package.\n\n## Links\n\n- [laravel-short-schedule](https://github.com/spatie/laravel-short-schedule)\n- [laravel-tail](https://github.com/spatie/laravel-tail)\n- [Task scheduling in Laravel](https://laravel.com/docs/master/scheduling)",
            "sort_order" => 3,
            "runtime" => 331,
            "thumbnail" => "https://i.vimeocdn.com/video/905264552_200x150.jpg?r=pad",
            "display" => "free",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 14:25:08",
        ]);
        $this->createVideoAndLesson([
            "series_id" => 1,
            "vimeo_id" => "426743340",
            "title" => "laravel-short-schedule part 2 => Under the hood",
            "slug" => "laravel-short-schedule-part-2-under-the-hood",
            "description" => "In this second part, we are going to explore how the package works under the hood.\n\n## Links\n\n- [laravel-short-schedule](github.com/spatie/laravel-short-schedule)\n- [ReactPHPl](https://reactphp.org)",
            "sort_order" => 4,
            "runtime" => 642,
            "thumbnail" => "https://i.vimeocdn.com/video/905267048_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 14:25:08",
        ]);
        $this->createVideoAndLesson([
            "series_id" => 1,
            "vimeo_id" => "426803489",
            "title" => "laravel-short-schedule part 3 => Testing the package",
            "slug" => "laravel-short-schedule-part-3-testing-the-package",
            "description" => "Testing functionality that uses a never ending loop doesn't have to be hard. In this video you'll learn a pragmatic way to tests ReactPHP loops.\n\n\n## Links\n\n- [laravel-short-schedule](github.com/spatie/laravel-short-schedule)\n- [ReactPHPl](https://reactphp.org)",
            "sort_order" => 5,
            "runtime" => 476,
            "thumbnail" => "https://i.vimeocdn.com/video/905365734_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:47",
        ]);
        $this->createVideoAndLesson([
            "series_id" => 2,
            "vimeo_id" => "381650670",
            "title" => "Refactor complex conditionals",
            "slug" => "refactor-complex-conditionals",
            "description" => "Most developers have probably seems some complex conditionals in legacy code. In this video I show you how to refactor those.",
            "sort_order" => 0,
            "runtime" => 387,
            "thumbnail" => "https://i.vimeocdn.com/video/843810342_200x150.jpg?r=pad",
            "display" => "free",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:47",
        ]);
        $this->createVideoAndLesson([
            "series_id" => 3,
            "vimeo_id" => "425443685",
            "title" => "Improving readability by decreasing indentation",
            "slug" => "improving-readability-by-decreasing-indentation",
            "description" => "Readability of code can be vastly improved by decreasing indentation. In this video we'll reverse conditions and early returns to accomplish this.\n\n## Links\n\n- [Object calisthenics](https://www.javaworld.com/article/2081135/object-calisthenics-change-the-way-you-code.html)",
            "sort_order" => 0,
            "runtime" => 283,
            "thumbnail" => "https://i.vimeocdn.com/video/902987575_200x150.jpg?r=pad",
            "display" => "free",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:47",
        ]);
        $this->createVideoAndLesson([
            "series_id" => 3,
            "vimeo_id" => "425400766",
            "title" => "Using lookup tables",
            "slug" => "using-lookup-tables",
            "description" => "If you have a big switch statement, or collection of if's, check if you can refactor is to a more readable variant => the lookup table.\n\n## Links\n\n- [Lookup table definition](https://en.wikipedia.org/wiki/Lookup_table)",
            "sort_order" => 1,
            "runtime" => 228,
            "thumbnail" => "https://i.vimeocdn.com/video/902910218_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:48",
        ]);
        $this->createVideoAndLesson([
            "series_id" => 3,
            "vimeo_id" => "420490355",
            "title" => "Refactor complex conditionals",
            "slug" => "refactor-complex-conditionals",
            "description" => null,
            "sort_order" => 2,
            "runtime" => 389,
            "thumbnail" => "https://i.vimeocdn.com/video/895751943_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:48",
        ]);

        $this->createVideoAndLesson([
            "series_id" => 3,
            "vimeo_id" => "424357726",
            "title" => "Getting autocompletion on models and API resources",
            "slug" => "getting-autocompletion-on-models-and-api-resources",
            "description" => "Wouldn't it be nice if you wouldn't have to guess the attributes of models and API resources? In this video, you'll learn how to use the laravel-ide-package to enable autocomplation for those type of classes.\n\n## Links\n\n- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)\n- [Laravel API Resources](https://laravel.com/docs/7.x/eloquent-resources)\n- [The mixin PHP DocBlock](https://freek.dev/1482-the-mixin-php-docblock)",
            "sort_order" => 3,
            "runtime" => 203,
            "thumbnail" => "https://i.vimeocdn.com/video/901251293_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:49",
        ]);

        $this->createVideoAndLesson([
            "series_id" => 3,
            "vimeo_id" => "424351669",
            "title" => "Using Blade components for layouts",
            "slug" => "using-blade-components-for-layouts",
            "description" => "Blade components are a wonderful feature of Laravel. Did you know you can use them for layouts as well?\n\n## Links\n\n- [Blade components documentation](https://laravel.com/docs/master/blade#components)\n- [Usage on freek.dev](https://github.com/spatie/freek.dev/blob/f9b8f6aec876f97f50b02b198ce8be2d3deeb9fb/resources/views/front/posts/show.blade.php#L1)",
            "sort_order" => 4,
            "runtime" => 227,
            "thumbnail" => "https://i.vimeocdn.com/video/901241986_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:49",
        ]);

        $this->createVideoAndLesson([
            "series_id" => 4,
            "vimeo_id" => "423805273",
            "title" => "Marking a video as completed using Livewire",
            "slug" => "marking-a-video-as-completed-using-livewire",
            "description" => "Whenever you finish viewing a video in the Laravel Package Training video section, that video will be marked as completed. You can also manually mark a video as (un)completed.\n\nThis video shows how we used Livewire to build that behaviour. We assume that you are already familiar with the general concepts of Livewire.\n\n## Links\n\n- [Laravel Package Training](https://laravelpackage.training)\n- [Livewire](https://laravel-livewire.com)",
            "sort_order" => 0,
            "runtime" => 344,
            "thumbnail" => "https://i.vimeocdn.com/video/900409866_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:49",
        ]);

        $this->createVideoAndLesson([
            "series_id" => 4,
            "vimeo_id" => "423805273",
            "title" => "Video 2",
            "slug" => "video-2",
            "description" => "Whenever you finish viewing a video in the Laravel Package Training video section, that video will be marked as completed. You can also manually mark a video as (un)completed.\n\nThis video shows how we used Livewire to build that behaviour. We assume that you are already familiar with the general concepts of Livewire.\n\n## Links\n\n- [Laravel Package Training](https://laravelpackage.training)\n- [Livewire](https://laravel-livewire.com)",
            "sort_order" => 0,
            "runtime" => 344,
            "thumbnail" => "https://i.vimeocdn.com/video/900409866_200x150.jpg?r=pad",
            "display" => "sponsors",
            "created_at" => "2020-06-24 12:48:52",
            "updated_at" => "2020-06-29 13:19:49",
        ]);

        $seriesWithFreeVideosAndSponsoredVideos = Series::create([
            'title' => 'Free + Sponsored',
            'slug' => 'free-sponsored',
            'description' => 'A series with 2 free videos and 1 sponsored only video',
            'sort_order' => '0',
            'type' => SeriesType::Video,
        ]);

        $this->createVideoAndLesson([
            "series_id" => $seriesWithFreeVideosAndSponsoredVideos->id,
            "vimeo_id" => "419946519",
            "title" => "Free video 1",
            "slug" => "free-video-1",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "display" => LessonDisplayEnum::FREE,
        ]);

        $this->createVideoAndLesson([
            "series_id" => $seriesWithFreeVideosAndSponsoredVideos->id,
            "vimeo_id" => "419946519",
            "title" => "Free video 2",
            "slug" => "free-video-2",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "display" => LessonDisplayEnum::FREE,
        ]);

        $this->createVideoAndLesson([
            "series_id" => $seriesWithFreeVideosAndSponsoredVideos->id,
            "vimeo_id" => "419946519",
            "title" => "Sponsor only video",
            "slug" => "sponsor-only-video",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "display" => LessonDisplayEnum::SPONSORS,
        ]);

        $courseWithFreeSamples = Series::create([
            'title' => 'Course with samples',
            'slug' => 'course-with-samples',
            'description' => 'A course with samples',
            'sort_order' => '0',
            'type' => SeriesType::Video,
        ]);

        $courseWithFreeSamples->purchasables()->attach(Purchasable::whereType('videos')->first());

        $this->createVideoAndLesson([
            "series_id" => $courseWithFreeSamples->id,
            "vimeo_id" => "419946519",
            "title" => "Free sample 1",
            "slug" => "free-sample-1",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "display" => LessonDisplayEnum::FREE,
        ]);

        $this->createVideoAndLesson([
            "series_id" => $courseWithFreeSamples->id,
            "vimeo_id" => "419946519",
            "title" => "Free sample for sponsors",
            "slug" => "free-sample-for-sponsors",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "display" => LessonDisplayEnum::SPONSORS,
        ]);

        $this->createVideoAndLesson([
            "series_id" => $courseWithFreeSamples->id,
            "vimeo_id" => "419946519",
            "title" => "Course only video",
            "slug" => "course-only-video",
            "runtime" => 1396,
            "thumbnail" => "https://i.vimeocdn.com/video/895982614_200x150.jpg?r=pad",
            "display" => LessonDisplayEnum::LICENSE,
        ]);
    }

    public function createVideoAndLesson(array $properties): void
    {
        $video = Video::create([
            'vimeo_id' => $properties['vimeo_id'],
            'title' => $properties['title'],
            'description' => $properties['description'] ?? '',
            'runtime' => $properties['runtime'],
            'thumbnail' => $properties['thumbnail'],
            'hash' => '',
        ]);

        Lesson::create([
            'content_type' => $video->getMorphClass(),
            'content_id' => $video->id,
            'series_id' => $properties['series_id'],
            'title' => $properties['title'],
            'chapter' => $properties['chapter'] ?? null,
            'slug' => $properties['slug'],
            'sort_order' => $properties['sort_order'] ?? null,
            'display' => $properties['display'],
        ]);
    }

    protected function createHtmlLessonAndLesson(array $properties)
    {
        $htmlLesson = HtmlLesson::create([
            'title' => $properties['title'],
            'markdown' => $properties['markdown'] ?? '',
        ]);

        Lesson::create([
            'content_type' => $htmlLesson->getMorphClass(),
            'content_id' => $htmlLesson->id,
            'series_id' => $properties['series_id'],
            'title' => $properties['title'],
            'chapter' => $properties['chapter'] ?? null,
            'chapter_slug' => Str::slug($properties['chapter'] ?? null),
            'slug' => Str::slug($properties['title']),
            'sort_order' => $properties['sort_order'] ?? null,
            'display' => $properties['display'],
        ]);
    }
}
