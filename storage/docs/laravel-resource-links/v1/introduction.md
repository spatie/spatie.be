---
title: Introduction
weight: 1
---
Let's say you have a `UsersController` with `index`, `show`, `create`, `edit`, `store`, `update` and `delete` methods and an `UserResource`. Wouldn't it be nice if you had the URL's to these methods immediately in your `UserResource` without having to construct them from scratch?

This package will add these links to your resource based upon a controller or actions you define. Let's look at an example of a resource.

``` php
class UserResource extends JsonResource
{
    use Spatie\ResourceLinks\HasLinks;
    use Spatie\ResourceLinks\HasMeta;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'links' => $this->links(UsersController::class),
        ];
    }

    public static function meta()
    {
        return [
            'links' => self::collectionLinks(UsersController::class),
        ];
    }
}
```

Now when creating an `UserResource` collection, you will have all the links from the `UserController` available:

```json
{
   "data":[
      {
         "id":1,
         "name": "Ruben Van Assche",
         "links": {
            "show": "https://laravel.app/users/1",
            "edit": "https://laravel.app/users/1/edit",
            "update": "https://laravel.app/users/1",
            "delete": "https://laravel.app/users/1"
         }
      }
   ],
   "meta": {
      "links": {
         "index": "https://laravel.app/users",
         "create": "https://laravel.app/users/create",
         "store":  "https://laravel.app/users"
      }
   }
}
```

## Why include links in your resources?

Let's say you're building a single-page application or an application built with [Inertia](https://inertiajs.com), then you have a PHP application running at the backend and a Javascript application at the front. These applications communicate with each other via an api but what if the frontend wants to route a user to another page?

Since routes are defined in the backend, the frontend has no idea where it has to route the user to. We could just write the url's in the javascript code but what if a route is changed? So why not pass these routes from the backend to the frontend? You could just manually write down all these routes, or let this package do that job for you.
