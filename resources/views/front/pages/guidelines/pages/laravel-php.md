---
title: Laravel & PHP
description: Artisanal
weight: 1
---

- [About Laravel](#about-laravel)
- [General PHP Rules](#general-php-rules)
- [Class defaults](#class-defaults)
- [Typed properties](#typed-properties)
- [Docblocks](#docblocks)
- [Strings](#strings)
- [If statements](#if-statements)
- [Ternary operators](#ternary-operators)
- [Comments](#comments)
- [Configuration](#configuration)
- [Artisan commands](#artisan-commands)
- [Routing](#routing)
- [Controllers](#controllers)
- [Views](#views)
- [Validation](#validation)
- [Blade templates](#blade-templates)
- [Authorization](#authorization)
- [Translations](#translations)
- [Naming classes](#naming-classes)

## About Laravel

First and foremost, Laravel provides the most value when you write things the way Laravel intended you to write. If there's a documented way to achieve something, follow it. Whenever you do something differently, make sure you have a justification for *why* you didn't follow the defaults.

## General PHP Rules

Code style must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-12](https://www.php-fig.org/psr/psr-12/). Generally speaking, everything string-like that's not public-facing should use camelCase. Detailed examples on these are spread throughout the guide in their relevant sections.

### Class defaults

By default, we don't use `final`. For our open source stuff, we assume that all our users know they are responsible for writing tests for any overwritten behaviour.

### Void return types

If a method return nothing, it should be indicated with `void`.
This makes it more clear to the users of your code what your intention was when writing it.

## Typed properties

You should type a property whenever possible. Don't use a docblock.

```php
// good
class Foo
{
    public string $bar;
}

// bad
class Foo
{
    /** @var string */
    public $bar;
}
```

## Docblocks

Don't use docblocks for methods that can be fully type hinted (unless you need a description).

Only add a description when it provides more context than the method signature itself. Use full sentences for descriptions, including a period at the end.

```php
// Good
class Url
{
    public static function fromString(string $url): Url
    {
        // ...
    }
}

// Bad: The description is redundant, and the method is fully type-hinted.
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

Always use fully qualified class names in docblocks.

```php
// Good

/**
 * @param string $url
 *
 * @return \Spatie\Url\Url
 */

// Bad

/**
 * @param string $foo
 *
 * @return Url
 */
```

Docblocks for class variables are required, as there's currently no other way to typehint these.

```php
// Good

class Foo
{
    /** @var \Spatie\Url\Url */
    private $url;

    /** @var string */
    private $name;
}

// Bad

class Foo
{
    private $url;
    private $name;
}
```

When possible, docblocks should be written on one line.

```php
// Good

/** @var string */
/** @test */

// Bad

/**
 * @test
 */
```

If a variable has multiple types, the most common occurring type should be first.

```php
// Good

/** @var \Spatie\Goo\Bar|null */

// Bad

/** @var null|\Spatie\Goo\Bar */
```

## Strings

When possible prefer string interpolation above `sprintf` and the `.` operator.

```php
// Good
$greeting = "Hi, I am {$name}.";
```

```php
// Bad
$greeting = 'Hi, I am ' . $name . '.';
```


## Ternary operators

Every portion of a ternary expression should be on its own line unless it's a really short expression.

```php
// Good
$result = $object instanceof Model
    ? $object->name
    : 'A default value';

$name = $isFoo ? 'foo' : 'bar';

// Bad
$result = $object instanceof Model ?
    $object->name :
   'A default value';
```

## If statements

### Bracket position

Always use curly brackets.

```php
// Good
if ($condition) {
   ...
}

// Bad
if ($condition) ...
```

### Happy path

Generally a function should have its unhappy path first and its happy path last. In most cases this will cause the happy path being in an unindented part of the function which makes it more readable.

```php
// Good

if (! $goodCondition) {
  throw new Exception;
}

// do work
```


```php
// Bad

if ($goodCondition) {
 // do work
}

throw new Exception;
```

### Avoid else

In general, `else` should be avoided because it makes code less readable. In most cases it can be refactored using early returns. This will also cause the happy path to go last, which is desirable.

```php
// Good

if (! $conditionBA) {
   // conditionB A failed

   return;
}

if (! $conditionB) {
   // conditionB A passed, B failed

   return;
}

// condition A and B passed
```

```php
// Bad

if ($conditionA) {
   if ($conditionB) {
      // condition A and B passed
   }
   else {
     // conditionB A passed, B failed
   }
}
else {
   // conditionB A failed
}
```


### Compound ifs

In general, separate `if` statements should be preferred over a compound condition. This makes debugging code easier.


```php
// Good
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

```php
// bad
if ($conditionA && $conditionB && $conditionC) {
  // do stuff
}
```



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

## Whitespace

Statements should have to breathe. In general always add blank lines between statements, unless they're a sequence of single-line equivalent operations. This isn't something enforceable, it's a matter of what looks best in its context.

```php
// Good
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

// Bad: Everything's cramped together.
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

```php
// Good: A sequence of single-line equivalent operations.
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

Don't add any extra empty lines between `{}` brackets.

```php
// Good
if ($foo) {
    $this->foo = $foo;
}

// Bad
if ($foo) {

    $this->foo = $foo;

}
```

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

## Artisan commands

The names given to artisan commands should all be kebab-cased.

```bash
# Good
php artisan delete-old-records

# Bad
php artisan deleteOldRecords
```

A command should always give some feedback on what the result is. Minimally you should let the `handle` method spit out a comment at the end indicating that all went well.

```php
// in a Command
public function handle()
{
    // do some work

    $this->comment('All ok!');
}
```

If possible use a descriptive success message eg. `Old records deleted`.

## Routing

Public-facing urls must use kebab-case.

```
https://spatie.be/open-source
https://spatie.be/jobs/front-end-developer
```

Route names must use camelCase.

```php
Route::get('open-source', 'OpenSourceController@index')->name('openSource');
```

```html
<a href="{{ route('openSource') }}">
    Open Source
</a>
```

All routes have an http verb, that's why we like to put the verb first when defining a route. It makes a group of routes very readable. Any other route options should come after it.

```php
// good: all http verbs come first
Route::get('/', 'HomeController@index')->name('home');
Route::get('open-source', 'OpenSourceController@index')->name('openSource');

// bad: http verbs not easily scannable
Route::name('home')->get('/', 'HomeController@index');
Route::name('openSource')->get('OpenSourceController@index');
```

Route parameters should use camelCase.

```php
Route::get('news/{newsItem}', 'NewsItemsController@index');
```

A route url should not start with `/` unless the url would be an empty string.

```php
// good
Route::get('/', 'HomeController@index');
Route::get('open-source', 'OpenSourceController@index');

//bad
Route::get('', 'HomeController@index');
Route::get('/open-source', 'OpenSourceController@index');
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

```php
// good
public function rules()
{
    return [
        'email' => ['required', 'email'],
    ];
}

// bad
public function rules()
{
    return [
        'email' => 'required|email',
    ];
}
```


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
