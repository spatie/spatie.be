---
title: Controllers
weight: 2
---

A controller can be added to an link group as such:

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'links' => $this->links(function (Links $links) {
                $links->controller(UsersController::class);
            }),
        ];
    }
}
```

It is possible to specify the parameters for the links:

```php
$links
    ->controller(UsersController::class)
    ->parameters(User::first());
```

Or prefix all the links of the controller:

```php
$links
    ->controller(UsersController::class)
    ->prefix('admin');
```

This will produce the following JSON:

``` json
"links": {
    "admin.show": "https://laravel.app/admin/users/1",
    "admin.edit": "https://laravel.app/admin/users/1/edit"
}
```

You can also choose the methods of the controller to include as links:

```php
$links
    ->controller(UsersController::class)
    ->methods(['create', 'index', 'show']);
```

Or even alias the name of methods:

```php
$links
    ->controller(UsersController::class)
    ->names(['index' => 'list']);
```

This will produce the following JSON:

``` json
"links": {
    "list": "https://laravel.app/admin/users"
}
```
