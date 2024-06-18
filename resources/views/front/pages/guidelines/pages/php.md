---
title: PHP
description: Back to the roots
weight: 2
---

## General PHP Rules

Code style must follow [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-12](https://www.php-fig.org/psr/psr-12/). Generally speaking, everything string-like that's not public-facing should use camelCase. Detailed examples on these are spread throughout the guide in their relevant sections.

### Class defaults

By default, we don't use `final`. In our team, there aren't many benefits that `final` offers as we don't rely too much on inheritance. For our open source stuff, we assume that all our users know they are responsible for writing tests for any overwridden behaviour.

### Nullable and union types

Whenever possible use the short nullable notation of a type, instead of using a union of the type with `null`.

[good]
```php
public ?string $variable;
```
[/good]

[good]
```php
public string | int | null $variable;
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
public function scopeArchived(Builder $query): void
{
    $query->where('status', Status::Archived);
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
```php
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
enum OrderStatus {  
    case Pending;
    case ReadyToDispatch;
    case Dispatched;
}
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

Always import the class names in docblocks.

[good]
```php
use Spatie\Url\Url

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
 * @var string
 */

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
 * @return \Illuminate\Support\Collection<int, SomeObject>
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
   } else {
     // condition A passed, B failed
   }
}
else {
   // condition A failed
}
```
[/bad]

Another option to refactor an `else` away is using a ternary.

[bad]
```php
if ($condition) {
    $this->doSomething();
} else {
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
// Everything's crammed together
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
// A sequence of single-line equivalent operations
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

## API routing

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
