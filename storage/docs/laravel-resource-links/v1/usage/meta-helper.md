---
title: Meta helper
weight: 3
---

## A little helper

When using collection links in your resource the code for adding these collection links can be quite confusing:

``` php
class UserResource extends JsonResource
{
    use Spatie\ResourceLinks\HasLinks;
    
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

That's why we've added a little helper which puts links immediately in the meta section of a resource collection:

``` php
class UserResource extends JsonResource
{
    use Spatie\ResourceLinks\HasLinks;
    use Spatie\ResourceLinks\HasMeta;
    
    public static function meta()
    {
        return [
            'links' => self::collectionLinks(UsersController::class)
        ];
    }
}
```

You can use this little helper by including the `Spatie\ResourceLinks\HasMeta` trait in your resource.

<div class="alert -warning">
When you include the `HasMeta` trait we overwrite following methods of the Laravel Resource: `toResponse`, `make` and `collection`.
If you overwrite these methods in your Resource, be sure to take the methods of the trait into account.
</div>
