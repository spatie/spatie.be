---
title: Merging links
weight: 5
---

When creating a single resource like `UserResource::make($user)` you not only want the links tied to that resource but also the collection links for that resource. In this case next to the `show`, `edit`, `update` and `delete` links you also want the `index`, `create` and `store` links in your resource.

This can be done by merging the collection links with the single resource links like so:

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'links' => $this->links(UsersController::class)->withCollectionLinks(),
        ];
    }
}

```

The `UserResource` in a response will now look like this:

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
            "delete": "https://laravel.app/users/1",
            "index": "https://laravel.app/users",
            "create": "https://laravel.app/users/create",
            "store":  "https://laravel.app/users"
         }
      }
   ]
}
```

### Automatically merge collection links

Calling `withCollectionLinks` on every resource can be a bit tedious. That's why when you include the `Spatie\ResourceLinks\HasMeta` we'll not only add the [meta](https://docs.spatie.be/laravel-resource-links/v1/usage/meta-helper/) helper but also automatic link merging when you would make a single resource.

Let's have a look, now when creating a single resource like so:

```php
UserResource::make($user);
```

You would get all the links: `show`, `edit`, `update`, `delete`, `index`, `create` and `store`. This will only work when making a single resource, collection resources will have their collection links in the meta section.
