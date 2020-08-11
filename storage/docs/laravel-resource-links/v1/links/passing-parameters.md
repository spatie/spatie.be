---
title: Passing parameters
weight: 5
---

You can pass parameters in different ways to an link type. By value's:

```php
$links
    ->controller(UsersController::class)
    ->parameters(User::first(), Post::first());
```

Or by array: 

```php
$links
    ->controller(UsersController::class)
    ->parameters([User::first(), Post::first()]);
```

You can even pass an associative array where the keys will be used for [parameter deducing](https://docs.spatie.be/laravel-resource-links/v1/usage/link-parameters/#parameter-resolving-rules):

```php
$links
    ->controller(UsersController::class)
    ->parameters(['user' => User::first(), 'post' => Post::first()]);
```

Lastly, `parameters` can be called as many times as you want:

```php
$links
    ->controller(UsersController::class)
    ->parameters(User::first())
    ->parameters(Post::first());
```
