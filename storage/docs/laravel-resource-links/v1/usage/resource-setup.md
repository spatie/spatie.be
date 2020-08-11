---
title: Resource setup
weight: 1
---

In your resources, add the `HasLinks` trait and a new key where the links will be stored:

``` php
use Spatie\ResourceLinks\HasLinks;

class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'links' => $this->links(UsersController::class),
        ];
    }
}

```

Now every `UserResource` has an additional `LinkResource` which in the responses will look like:

``` json
{
    'id': 1,
    'name': 'Ruben'
    'links': {
        "show": "https://laravel.app/users/1",
        "edit": "https://laravel.app/users/1/edit",
        "update": "https://laravel.app/users/1",
        "delete": "https://laravel.app/users/1"
    }
}
```

By default, we'll only construct links from the `show`, `edit`, `update` and `delete` methods of your controller.

## Collection links

What about links like `index`, `create` and `store`? These links are not tied to a single model instance, so it's not a good idea to store them at that level. Instead, it's better to put the links to those collection links on the collection level of a resource.

You can put the collection links in the meta section of a resource collection like so:

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'links' => $this->links(UsersController::class),
        ];
    }

    public static function collection($resource)
    {
        return parent::collection($resource)->additional([
            'meta' => [
                'links' => self::collectionLinks(UsersController::class)
             ],
         ]);
    }
}
```

Now when we create an `UserResource` collection, the meta section will look like this:

``` json
"meta": {
   "links": {
        "index": "https://laravel.app/users",
        "create": "https://laravel.app/users/create",
        "store":  "https://laravel.app/users"
   }
}
```

By default, the collection links will only be constructed for the `index`, `create` and `store` methods in your controller.
