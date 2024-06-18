---
title: Laravel
description: Artisanal baked code
weight: 1
---

## About Laravel

First and foremost, Laravel shines brightest when you stick to its conventions. If there's a documented way to achieve something, follow it. If you want to stray away from the defaults, have a justified reason for it.

## Configuration

Configuration files must use kebab-case.

```
config/
  pdf-generator.php
```

Configuration keys must use snake_case. Do not use the `env` helper outside of configuration files. Use it as a configuration value instead. Using configuration files, reading environment variables won't down your app as they'll be  cached with `php artisan config:cache`.

```php
// config/pdf-generator.php
return [
    'chrome_path' => env('CHROME_PATH'),
];
```

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
        'token' => env('WEYLAND_YUTANI_TOKEN'),
    ],   
];
```
[/good]

[bad]
```php
// Creating a new config file: `weyland-yutani.php`

return [
    'token' => env('WEYLAND_YUTANI_TOKEN'),
]
```
[/bad]

## Facades

Avoid using facade aliases for better IDE support. Import them using their fully qualified class names instead.

[good]
```php
use Illuminate\Support\Facades\Request;
```
[/good]

[bad]
```php
use Request;
```
[/bad]

## Routing

Public-facing urls must use kebab-case.

```
https://spatie.be/open-source
https://spatie.be/jobs/front-end-developer
```

Use Laravel's tuple notation to register and link to route actions. This way, your IDE and static analysis tools will analyze up controller names when linting or refactoring. 

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

When using route names, write them in camelCase.

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

All routes have an HTTP verb and path, that's why we like to them first when fluently defining a route. It makes a group of routes very readable. Any other options come after.

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

A route url should not start with `/` for clarity when the path is empty.

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

## Artisan Commands

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

A command should always give feedback on the result is. Minimally you should let the `handle` method spit out a comment at the end indicating that all went well.

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

[good]
```php
public function handle()
{
    $this->comment("Start processing items...");

    $items->each(function(Item $item) {
        $this->info("Processing item {$item-id}…");

        $this->processItem($item);
    });

    $this->comment("Processed {$item->count()} items.");
}
```
[/good]

[bad]
```php
public function handle()
{
    $this->comment("Start processing items...");

    $items->each(function(Item $item) {
        $this->processItem($item);
        
        $this->info("Processed item {$item-id}.");
    });

    $this->comment("Processed {$item->count()} items.");
}
```
[/bad]

## Controllers

Controllers that control a resource must use the plural resource name.

```php
class PostsController
{
    // ...
}
```

Try to keep controllers simple and stick to the default CRUD keywords (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) or create invokable controllers with an explicit name.

[good]
```php
class PostsController
{
    public function create()
    {
        return view('posts.create');
    }
}

class FavoritePostController
{
    public function __invoke(Post $post)
    {
        request()->user()->favorites()->attach($post);

        return response(null, 200);
    }
}
```
[/good]

[bad]
```php
class PostsController
{
    public function create()
    {
        return view('posts.create');
    }

    public function favorite(Post $post)
    {
        request()->user()->favorites()->attach($post);

        return response(null, 200);
    }
}
```
[/bad]

## Views

View files must use camelCase.

[good]
```
resources/
  views/
    openSource.blade.php
```
[/good]

[good]
```php
class OpenSourceController
{
    public function index() {
        return view('openSource');
    }
}
```
[/good]

[bad]
```
resources/
  views/
    open-source.blade.php
```
[/bad]

[bad]
```php
class OpenSourceController
{
    public function index() {
        return view('open-source');
    }
}
```
[/bad]

## Validation

When using multiple rules for one field in a form request, avoid using a long string with `|`. Use array notation instead. Using an array notation will also make it easier to apply custom rule classes to a field later.

[good]
```php
public function rules(): array
{
    return [
        'email' => ['required', 'email', MyCustomRule::class],
    ];
}
```
[/good]

[bad]
```php
public function rules(): array
{
    return [
        'email' => 'required|email|' . MyCustomRule::class,
    ];
}
```
[/bad]


Custom validation rules must use snake_case:

```php
Validator::extend('organisation_type', function ($attribute, $value) {
    return OrganisationType::isValid($value);
});
```

## Blade Templates

Indent using four spaces. Don't add spaces after control structure keywords.
[good]
```html
@if($condition)
    Something
@endif
```
[/good]

[bad]
```html
@if ($condition)
  Something
@endif
```
[/bad]

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

## Naming Things

Naming things is often seen as one of the harder things in programming. That's why we've established some high level guidelines for naming classes.

Tl;dr: Add a suffix to most things for clarity and to avoid naming collisions. Models are not suffixed.

[good]
```php
class Podcast {}
class PodcastData {}
class PodcastRequest {}
class PodcastResource {}

class ProcessPodcastJob {}
class ProcessPodcastAction {}
class ProcessPodcastCommand {}
class ProcessPodcastListener {}
class ProcessPodcastController {}
```
[/good]

### Controllers

Generally controllers are named by the plural form of their corresponding resource and a `Controller` suffix. This is to avoid naming collisions with models that are often equally named.

e.g. `UsersController` or `EventDaysController`

When writing non-resourceful controllers you might come across invokable controllers that perform a single action. These can be named by the action they perform again suffixed by `Controller`.

e.g. `PerformCleanupController`

### Resources (and transformers)

Both Eloquent and Laravel Data resources are singular suffixed with `Resource`. This is to avoid naming collisions with models.

[good]
```php
class UserResource extends Data {}
```
[/good]

[bad]
```php
class UsersResource extends Data {}
```
[/bad]

### Jobs

A job's name should describe its action. Jobs should be suffixed with `Job` to avoid clashes with similarly named actions.

[good]
```php
class ProcessPodcastJob extends Job
{
    public function __construct(
        public Podcast $podcast,
    ) {
    }

    public function handle(): void
    {
        resolve(ProcessPodcast::class)->execute($this->podcast);    
    }
} 
```
[/good]

[bad]
```php
class ProcessPodcast extends Job
{
    public function __construct(
        public Podcast $podcast,
    ) {
    }

    public function handle(): void
    {
        resolve(ProcessPodcastAction::class)->execute($this->podcast);    
    }
} 
```
[/bad]

### Events

Events will often be fired before or after something occurs in the real world. This should be very clear by the tense used in their name.

E.g. `ApprovingLoan` before the action is completed and `LoanApproved` after the action is completed.

[good]
```php
class ApproveLoan
{
    public function execute(Loan $loan): void
    {
        event(new ApprovingLoan($loan));
        
        // Do approval stuff…
        
        $loan->update(['status' => Status::Approved]);
        
        event(new LoanApproved($loan));
    }
}
```
[/good]

[bad]
```php
class ApproveLoan
{
    public function execute(Loan $loan): void
    {
        event(new LoanApproved($loan));
        
        // Do approval stuff…
        
        $loan->update(['status' => Status::Approved]);
    }
}
```
[/bad]

### Listeners

Listeners will perform an action based on an incoming event. Their name should reflect their action with a `Listener` suffix. This might seem strange at first but will avoid naming collisions with jobs.

[good]
```php
class SendInvitationMailListener {}
```
[/good]

[bad]
```php
class MemberInvitedListener {}
```
[/bad]

### Commands

To avoid naming collisions we suffix commands with `Command`. Use the context of the command as the first part of the signature and the action as the second. Use explicit argument names. `podcastId` makes it clear that you need to pass an ID. 

[good]
```php
class ProcessPodcastCommand extends Command
{
    protected $signature = 'podcast:process {podcastId}';

    public function handle(): void
    {
        resolve(ProcessPodcast::class)
            ->execute(Podcast::find($this->argument('podcastId')));    
    }
} 
```
[/good]

[bad]
```php
class ProcessPodcast extends Command
{
    protected $signature = 'process-podcast {podcast}';

    public function handle(): void
    {
        resolve(ProcessPodcastAction::class)
            ->execute(Podcast::find($this->argument('podcast')));    
    }
} 
```
[/bad]

### Mailables

Again to avoid naming collisions we'll suffix mailables with `Mail`, as they're often used to convey an event, action or question.

[good]
```php
class AccountActivatedMail extends Mailable {}
```
[/good]

[bad]
```php
class AccountActivated extends Mailable {}
```
[/bad]

### Livewire Components

Livewire components don't need to be suffixed to avoid having a `component` suffix in Blade views.

[good]
```php
class EditProfile extends Component {}
```
[/good]

[good]
```html
<livewire:edit-profile />
```
[/good]

[bad]
```php
class EditProfileComponent extends Component {}
```
[/bad]

[bad]
```html
<livewire:edit-profile-component />
```
[/bad]

### Enums

Enums don't need to be suffixed as in most cases, it is clear by reading the name that it is an enum.

[good]
```php
enum OrderStatus {}
```
[/good]

[bad]
```php
enum OrderStatusEnum {}
```
[/bad]
