---
title: Link groups
weight: 1
---

Sometimes a more fine-grained control is needed to construct links. Let's say you want to prefix a set of links, change the name of an link, or specify which links to include. That's where link groups come into place. You can now create a resource with controller link as such:

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

Off course it is possible to use link groups with collection links:

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public static function collection($resource)
    {
        return parent::collection($resource)->additional([
            'meta' => [
                'links' => self::collectionLinks(function (Links $links) {
                    $links->controller(UsersController::class);
                })
             ],
         ]);
    }
}
```

In the following sections we'll explain which link types you can create in an link group.
