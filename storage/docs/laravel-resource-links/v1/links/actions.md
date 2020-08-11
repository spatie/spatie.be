---
title: Actions
weight: 3
---

Next to controllers, you can also add actions to an links group:

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'links' => $this->links(function (Links $links) {
                $links->action([UsersController::class, 'create']);
            }),
        ];
    }
}
```

Is possible to specify the parameters for the links:

```php
$links
    ->action([UsersController::class, 'create'])
    ->parameters(User::first());
```

Or prefix the link:

```php
$links
    ->action([UsersController::class, 'create'])
    ->prefix('admin');
```

The name of the action can also be changed:

```php
$links
    ->action([UsersController::class, 'create'])
    ->name('build');
```

Changing the Http verb(POST, GET, …) of the action can be done as such:

```php
$links
    ->action([UsersController::class, 'create'])
    ->httpVerb('POST');
```
