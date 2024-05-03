---
title: Laravel & PHP
description: Artisanal baked code
weight: 1
---

## About Laravel

First and foremost, Laravel provides the most value when you write things the way Laravel intended you to write. If there's a documented way to achieve something, follow it. Whenever you do something differently, make sure you have a justification for *why* you didn't follow the defaults.

## General PHP Rules

Code style must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-12](https://www.php-fig.org/psr/psr-12/). Generally speaking, everything string-like that's not public-facing should use camelCase. Detailed examples on these are spread throughout the guide in their relevant sections.

### Class defaults

By default, we don't use `final`. In our team, there aren't many benefits that `final` offers as we don't rely too much on inheritance. For our open source stuff, we assume that all our users know they are responsible for writing tests for any overwritten behaviour.

### Nullable and union types

Whenever possible use the short nullable notation of a type, instead of using a union of the type with `null`.

[good]
```php
public ?string $variable;
```
[/good]

[bad]
```php
public string | null $variable;
```
[/bad]

### Void return types

If a method returns nothing, it should be indicated with `void`.
This makes it clearer to the users of your code what your intention was when writing it.

[good]
```php
// in a Laravel model
public function scopeArchived(Builder $query): void
{
    $query->
        ...
}
```
[/good]


## Typed properties

You should type a property whenever possible. Don't use a docblock.

[good]
```php
class Foo
{
    public string $bar;
}
```
[/good]


[bad]
```
class Foo
{
    /** @var string */
    public $bar;
}
```
[/bad]

## Enums

Values in enums should use PascalCase. 

```php
enum Suit {  
    case Clubs;
    case Diamonds;
    case Hearts;
    case Spades;
}

Suit::Diamonds;
```

## Docblocks

Don't use docblocks for methods that can be fully type hinted (unless you need a description).

Only add a description when it provides more context than the method signature itself. Use full sentences for descriptions, including a period at the end.

[good]
```php
class Url
{
    public static function fromString(string $url): Url
    {
        // ...
    }
}
```
[/good]

[bad]
```php
// The description is redundant, and the method is fully type-hinted.
class Url
{
    /**
     * Create a url from a string.
     *
     * @param string $url
     *
     * @return \Spatie\Url\Url
     */
    public static function fromString(string $url): Url
    {
        // ...
    }
}
```
[/bad]

Always import the classnames in docblocks.

[good]
```php
use \Spatie\Url\Url

/**
 * @param string $foo
 *
 * @return Url
 */
 ```
[/good]

[bad]
```php
/**
 * @param string $url
 *
 * @return \Spatie\Url\Url
 */
```
[/bad]

Using multiple lines for a docblock, might draw too much attention to it. When possible, docblocks should be written on one line.

[good]
```php
/** @var string */
/** @test */
``` 
[/good]

[bad]
```php
/**
 * @test
 */
```
[/bad]

If a variable has multiple types, the most common occurring type should be first.

[good]
```php
/** @var \Illuminate\Support\Collection|\SomeWeirdVendor\Collection */
```
[/good]

[bad]
```php
/** @var \SomeWeirdVendor\Collection|\Illuminate\Support\Collection */
```
[/bad]

If a function requires a docblock for a single parameter or return type, add all other docblocks as well.

[good]
```php
/** 
 * @param string $name
 * @return \Illuminate\Support\Collection<SomeObject> 
 */
function someFunction(string $name): Collection {
    //
}
```
[/good]

[bad]
```php
/** 
 * @return \Illuminate\Support\Collection<SomeObject>
 */
function someFunction(string $name): Collection {
    //
}
```
[/bad]

## Docblocks for iterables

When your function gets passed an iterable, you should add a docblock to specify the type of key and value. This will greatly help static analysis tools understand the code, and IDEs to provide autocompletion.

```php
/**
 * @param $myArray array<int, MyObject>
 */
function someFunction(array $myArray) {

}
```


In this example, `typedArgument` needs a docblock too:

```php
/**
 * @param $myArray array<int, MyObject>
 * @param int $typedArgument 
 */
function someFunction(array $myArray, int $typedArgument) {

}
```

The keys and values of iterables that get returned should always be typed.

```php
use \Illuminate\Support\Collection

/**
 * @return \Illuminate\Support\Collection<int,SomeObject>
 */
function someFunction(): Collection {
    //
}
```

If your array or collection has a few fixed keys, you can typehint them too using `{}` notation.

```php
use \Illuminate\Support\Collection

/**
 * @return array{first: SomeClass, second: SomeClass}
 */
function someFunction(): array {
    //
}
```

If there is only one docblock needed, you may use the short version.

```php
use \Illuminate\Support\Collection

/** @return \Illuminate\Support\Collection<int,SomeObject> */
function someFunction(): Collection {
    //
}
```

## Constructor property promotion

Use constructor property promotion if all properties can be promoted. To make it readable, put each one on a line of its own. Use a comma after the last one.

[good]
```php
class MyClass {
    public function __construct(
        protected string $firstArgument,
        protected string $secondArgument,
    ) {}
}
```
[/good]

[bad]
```php
class MyClass {
    protected string $secondArgument

    public function __construct(protected string $firstArgument, string $secondArgument)
    {
        $this->secondArgument = $secondArgument;
    }
}
```
[/bad]

## Traits

Each applied trait should go on its own line, and the `use` keyword should be used for each of them. This will result in clean diffs when traits are added or removed.

[good]
```php
class MyClass
{
    use TraitA;
    use TraitB;
}
```
[/good]

[bad]
```php
class MyClass
{
    use TraitA, TraitB;
}
```
[/bad]

## Strings

When possible prefer string interpolation above `sprintf` and the `.` operator.

[good]
```php
$greeting = "Hi, I am {$name}.";
```
[/good]

[bad]
```php
$greeting = 'Hi, I am ' . $name . '.';
```
[/bad]


## Ternary operators

Every portion of a ternary expression should be on its own line unless it's a really short expression.

[good]
```php
$name = $isFoo ? 'foo' : 'bar';
```
[/good]

[good]
```php
$result = $object instanceof Model ?
    $object->name :
   'A default value';
```
[/good]

## If statements

### Bracket position

Always use curly brackets.

[good]
```php
if ($condition) {
   ...
}
```
[/good]

[bad]
```php
if ($condition) ...
```
[/bad]

### Happy path

Generally a function should have its unhappy path first and its happy path last. In most cases this will cause the happy path being in an unindented part of the function which makes it more readable.

[good]
```php
if (! $goodCondition) {
  throw new Exception;
}
```
[/good]


[bad]
```php
if ($goodCondition) {
 // do work
}

throw new Exception;
```
[/bad]

### Avoid else

In general, `else` should be avoided because it makes code less readable. In most cases it can be refactored using early returns. This will also cause the happy path to go last, which is desirable.

[good]
```php
if (! $conditionA) {
   // condition A failed

   return;
}

if (! $conditionB) {
   // condition A passed, B failed

   return;
}

// condition A and B passed
```
[/good]

[bad]
```php
if ($conditionA) {
   if ($conditionB) {
      // condition A and B passed
   }
   else {
     // condition A passed, B failed
   }
}
else {
   // condition A failed
}
```
[/bad]

Another option to refactor an `else` away is using a ternary

[bad]
```php
if ($condition) {
    $this->doSomething();
} 
else {
    $this->doSomethingElse();
}
```
[/bad]

[good]
```php
$condition
    ? $this->doSomething()
    : $this->doSomethingElse();
```
[/good]

### Compound ifs

In general, separate `if` statements should be preferred over a compound condition. This makes debugging code easier.


[good]
```php
if (! $conditionA) {
   return;
}

if (! $conditionB) {
   return;
}

if (! $conditionC) {
   return;
}

// do stuff
```
[/good]

[bad]
```php
if ($conditionA && $conditionB && $conditionC) {
  // do stuff
}
```
[/bad]

## Comments

Comments should be avoided as much as possible by writing expressive code. If you do need to use a comment, format it like this:

```php
// There should be a space before a single line comment.

/*
 * If you need to explain a lot you can use a comment block. Notice the
 * single * on the first line. Comment blocks don't need to be three
 * lines long or three characters shorter than the previous line.
 */
```

A possible strategy to refactor away a comment is to create a function with name that describes the comment

[good]
```php
$this->calculateLoans();
```
[/good]

[bad]
```php
// Start calculating loans
```
[/bad]

## Test classes

If you need a specific class for your test cases, you should keep them within the same test file when possible. When you want to reuse test classes throughout tests, it's fine to make a dedicated class instead. Here's an example of internal classes:

```php
<?php

namespace Spatie\EventSourcing\Tests\AggregateRoots;

// …

class AggregateEntityTest extends TestCase
{
    /** @test */
    public function test_entities()
    {
        // …
    }
}

class ItemAdded extends ShouldBeStored
{
    public function __construct(
        public string $name
    ) {
    }
}

class CartCleared extends ShouldBeStored
{
}
```

## Whitespace

Statements should be allowed to breathe. In general always add blank lines between statements, unless they're a sequence of single-line equivalent operations. This isn't something enforceable, it's a matter of what looks best in its context.

[good]
```php
public function getPage($url)
{
    $page = $this->pages()->where('slug', $url)->first();

    if (! $page) {
        return null;
    }

    if ($page['private'] && ! Auth::check()) {
        return null;
    }

    return $page;
}
```
[/good]

[bad]
```php
// Everything's cramped together.
public function getPage($url)
{
    $page = $this->pages()->where('slug', $url)->first();
    if (! $page) {
        return null;
    }
    if ($page['private'] && ! Auth::check()) {
        return null;
    }
    return $page;
}
```
[/bad]

[good]
```php
// A sequence of single-line equivalent operations.
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```
[/good]

Don't add any extra empty lines between `{}` brackets.

[good]
```php
if ($foo) {
    $this->foo = $foo;
}
```
[/good]

[bad]
```php
if ($foo) {

    $this->foo = $foo;
}
```
[/bad]

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

## Api routing

Naming conventions:
1. Use the **plural** form of the resource name. (e.g. `errors`)
2. Use **kebab-case** for the resource name. (e.g. `error-occurrences`)
3. **Limit deep nesting**. Deeply nested routes can make the API complex and harder to manage. By limiting nesting, you maintain simplicity and improve readability.

[bad]
```
/projects/1/errors/1/error-occurrences/1
```
[/bad]

[good]
```
/error-occurrences/1
```
[/good]

There are situations where providing context through nesting is necessary and beneficial. If the relationship between resources requires additional context, it's acceptable to use deeper nesting.

If you need to access all occurrences of a specific error, nesting occurrences under errors provides clear context.

[good]
```
/errors/1/occurrences
```
[/good]

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
