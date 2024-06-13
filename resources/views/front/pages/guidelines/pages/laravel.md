---
title: Laravel
description: Artisanal baked code
weight: 1
---

## About Laravel

First and foremost, Laravel provides the most value when you write things the way Laravel intended you to write. If there's a documented way to achieve something, follow it. Whenever you do something differently, make sure you have a justification for *why* you didn't follow the defaults.

## Configuration

Configuration files must use kebab-case.

```
config/
  pdf-generator.php
```

Configuration keys must use snake_case.

```php
// config/pdf-generator.php
return [
    'chrome_path' => env('CHROME_PATH'),
];
```

Avoid using the `env` helper outside of configuration files. Create a configuration value from the `env` variable like above.

When adding config values for a specific service, add them to the `services` config file. Do not create a new config file.

[good]
```php
// Adding credentials to `config/services.php`
return [
    'ses' => [
        'key' => env('SES_AWS_ACCESS_KEY_ID'),
        'secret' => env('SES_AWS_SECRET_ACCESS_KEY'),
        'region' => env('SES_AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'github' => [
        'username' => env('GITHUB_USERNAME'),
        'token' => env('GITHUB_TOKEN'),
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_CALLBACK_URL'),
        'docs_access_token' => env('GITHUB_ACCESS_TOKEN'),
    ],
    
    'weyland_yutani' => [
        'token' => env('WEYLAND_YUTANI_TOKEN')
    ],   
];
```
[/good]

[bad]
```php
// Creating a new config file: `weyland-yutani.php`

return [
    'weyland_yutani' => [
        'token' => env('WEYLAND_YUTANI_TOKEN')
    ],  
]
```
[/bad]

## Routing

Public-facing urls must use kebab-case.

```
https://spatie.be/open-source
https://spatie.be/jobs/front-end-developer
```

Prefer to use the route tuple notation when possible.

[good]
```php
Route::get('open-source', [OpenSourceController::class, 'index']);
```
[/good]


[bad]
```php
Route::get('open-source', 'OpenSourceController@index');
```
[/bad]

[good]
```html
<a href="{{ action([\App\Http\Controllers\OpenSourceController::class, 'index']) }}">
    Open Source
</a>
```
[/good]

Route names must use camelCase.

[good]
```php
Route::get('open-source', [OpenSourceController::class, 'index'])->name('openSource');
```
[/good]

[bad]
```php
Route::get('open-source', [OpenSourceController::class, 'index'])->name('open-source');
```
[/bad]

All routes have an HTTP verb, that's why we like to put the verb first when defining a route. It makes a group of routes very readable. Any other route options should come after it.

[good]
```php
// all HTTP verbs come first
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('open-source', [OpenSourceController::class, 'index'])->name('openSource');
```
[/good]

[bad]
```php
// HTTP verbs not easily scannable
Route::name('home')->get('/', [HomeController::class, 'index']);
Route::name('openSource')->get([OpenSourceController::class, 'index']);
```
[/bad]

Route parameters should use camelCase.

```php
Route::get('news/{newsItem}', [NewsItemsController::class, 'index']);
```

A route url should not start with `/` unless the url would be an empty string.

[good]
```php
Route::get('/', [HomeController::class, 'index']);
Route::get('open-source', [OpenSourceController::class, 'index']);
```
[/good]

[bad]
```php
Route::get('', [HomeController::class, 'index']);
Route::get('/open-source', [OpenSourceController::class, 'index']);
```
[/bad]




## Artisan commands

The names given to artisan commands should all be kebab-cased.

[good]
```bash
php artisan delete-old-records
```
[/good]

[bad]
```bash
php artisan deleteOldRecords
```
[/bad]

A command should always give some feedback on what the result is. Minimally you should let the `handle` method spit out a comment at the end indicating that all went well.

```php
// in a Command
public function handle()
{
    // do some work

    $this->comment('All ok!');
}
```

When the main function of a result is processing items, consider adding output inside of the loop, so progress can be tracked. Put the output before the actual process. If something goes wrong, this makes it easy to know which item caused the error.

At the end of the command, provide a summary on how much processing was done.

```php
// in a Command
public function handle()
{
    $this->comment("Start processing items...");

    // do some work
    $items->each(function(Item $item) {
        $this->info("Processing item id `{$item-id}`...");

        $this->processItem($item);
    });

    $this->comment("Processed {$item->count()} items.");
}
```

## Controllers

Controllers that control a resource must use the plural resource name.

```php
class PostsController
{
    // ...
}
```

Try to keep controllers simple and stick to the default CRUD keywords (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`). Extract a new controller if you need other actions.

In the following example, we could have `PostsController@favorite`, and `PostsController@unfavorite`, or we could extract it to a separate `FavoritePostsController`.

```php
class PostsController
{
    public function create()
    {
        // ...
    }

    // ...

    public function favorite(Post $post)
    {
        request()->user()->favorites()->attach($post);

        return response(null, 200);
    }

    public function unfavorite(Post $post)
    {
        request()->user()->favorites()->detach($post);

        return response(null, 200);
    }
}
```

Here we fall back to default CRUD words, `store` and `destroy`.

```php
class FavoritePostsController
{
    public function store(Post $post)
    {
        request()->user()->favorites()->attach($post);

        return response(null, 200);
    }

    public function destroy(Post $post)
    {
        request()->user()->favorites()->detach($post);

        return response(null, 200);
    }
}
```

This is a loose guideline that doesn't need to be enforced.

## Views

View files must use camelCase.

```
resources/
  views/
    openSource.blade.php
```

```php
class OpenSourceController
{
    public function index() {
        return view('openSource');
    }
}
```

## Validation

When using multiple rules for one field in a form request, avoid using `|`, always use array notation. Using an array notation will make it easier to apply custom rule classes to a field.

[good]
```php
public function rules()
{
    return [
        'email' => ['required', 'email'],
    ];
}
```
[/good]

[bad]
```php
public function rules()
{
    return [
        'email' => 'required|email',
    ];
}
```
[/bad]


All custom validation rules must use snake_case:

```php
Validator::extend('organisation_type', function ($attribute, $value) {
    return OrganisationType::isValid($value);
});
```

## Blade Templates

Indent using four spaces.

```html
<a href="/open-source">
    Open Source
</a>
```

Don't add spaces after control structures.

```html
@if($condition)
    Something
@endif
```

## Authorization

Policies must use camelCase.

```php
Gate::define('editPost', function ($user, $post) {
    return $user->id == $post->user_id;
});
```

```html
@can('editPost', $post)
    <a href="{{ route('posts.edit', $post) }}">
        Edit
    </a>
@endcan
```

Try to name abilities using default CRUD words. One exception: replace `show` with `view`. A server shows a resource, a user views it.

## Translations

Translations must be rendered with the `__` function. We prefer using this over `@lang` in Blade views because `__` can be used in both Blade views and regular PHP code. Here's an example:

```php
<h2>{{ __('newsletter.form.title') }}</h2>

{!! __('newsletter.form.description') !!}
```

## Naming Classes

Naming things is often seen as one of the harder things in programming. That's why we've established some high level guidelines for naming classes.

### Controllers

Generally controllers are named by the plural form of their corresponding resource and a `Controller` suffix. This is to avoid naming collisions with models that are often equally named.

e.g. `UsersController` or `EventDaysController`

When writing non-resourceful controllers you might come across invokable controllers that perform a single action. These can be named by the action they perform again suffixed by `Controller`.

e.g. `PerformCleanupController`

### Resources (and transformers)

Both Eloquent resources and Fractal transformers are plural resources suffixed with `Resource` or `Transformer` accordingly. This is to avoid naming collisions with models.

### Jobs

A job's name should describe its action.

E.g. `CreateUser` or `PerformDatabaseCleanup`

### Events

Events will often be fired before or after the actual event. This should be very clear by the tense used in their name.

E.g. `ApprovingLoan` before the action is completed and `LoanApproved` after the action is completed.

### Listeners

Listeners will perform an action based on an incoming event. Their name should reflect that action with a `Listener` suffix. This might seem strange at first but will avoid naming collisions with jobs.

E.g. `SendInvitationMailListener`

### Commands

To avoid naming collisions we'll suffix commands with `Command`, so they are easiliy distinguisable from jobs.

e.g. `PublishScheduledPostsCommand`

### Mailables

Again to avoid naming collisions we'll suffix mailables with `Mail`, as they're often used to convey an event, action or question.

e.g. `AccountActivatedMail` or `NewEventMail`

### Enums

Enums don't need to be prefixed as in most cases, it is clear by reading the name that it is an enum.

e.g. `OrderStatus` or `BookingType` or `Suit`
