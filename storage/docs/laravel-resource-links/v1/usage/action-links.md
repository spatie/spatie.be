---
title: Action links
weight: 2
---

Sometimes you want to add links not belonging to a specific controller. Then it is possible to add an action as an link. They look just like a standard Laravel action:

``` php
class OtherResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'links' => $this->links()->action([UsersController::class, 'create']),
        ];
    }
}
```

The HTTP verb for the action will be resolved from the route in Laravel. Should you have an action with two verbs, then you can always specify the verb for a particular action:

``` php
class OtherResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        $user = Auth::user();

        return [
            'links' => $this->links()
                ->action([UsersController::class, 'update'], [], 'PUT'),
        ];
    }
}
```

Of course, it is also possible to use this with collection links:

``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public static function collection($resource)
    {
        return parent::collection($resource)->additional([
            'meta' => [
                'links' => self::collectionLinks(UsersController::class)
                    ->action([UsersController::class, 'update'], [], 'PUT'),
             ],
         ]);
    }
}
```
