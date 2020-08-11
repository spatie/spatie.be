---
title: Invokable controllers
weight: 4
---

Invokable controllers can be written as actions

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'links' => $this->links(function (Links $links) {
                $links->action(DownloadUserController::class);
            }),
        ];
    }
}
```

By default the `__invoke()` method of this controller will be created with the name `invoke. This will produce following JSON:

``` json
"links": {
    "invoke": {
       "method": "GET",
       "action": "https://laravel.app/admin/users/1/download"
    },
}
```

Want to be more explicit? You can also add an invokable controller to a link group as such:

```php
$links->controller(DownloadUserController::class);
```

Off course you can use the methods defined by an action on this controller:

```php
$links
    ->controller(DownloadUserController::class)
    ->name('download');
```
