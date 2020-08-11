---
title: Link parameters
weight: 4
---

A link resource will try to deduce the parameters for a route as best as possible when generating the link to that route. Without extra configuration the parameters of the current request and the current model given to the resource are used to construct the links.

But it is also possible to specify your own parameters:

```php
class UserResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
	    return [
	        'links' => $this->links(UsersController::class, [
	            'user' => Auth::user(),
	        ]),
	        //
	    ];
    }
}
```

Or for collection links:


``` php
class UserResource extends JsonResource
{
    use HasLinks;

    public static function collection($resource)
    {
        return parent::collection($resource)->additional([
            'meta' => [
                'links' => self::collectionLinks(UsersController::class, [
                    'user' => Auth::user()
                ])
             ],
         ]);
    }
}
```

And for actions:

``` php
class OtherResource extends JsonResource
{
    use HasLinks;

    public function toArray($request)
    {
        return [
            'links' => $this->links()->action([UsersController::class, 'show'], [
                'user' => Auth::user(),
            ]),
        ];
    }
}
```

### Parameter resolving rules

A link has zero or more signature parameters(i.e. the parameters of your function you're routing to) that should be filled in when creating a url to an link.

We use a set of rules to deduce a correct value for the signature parameters. For each signature parameter these rules are checked: when a value of a rule fits the signature parameter it will be used.

The rule are executed in following order:

1. If the type of the signature parameter is the same as the model given to the resource, use the model as value
2. Search in the provided parameters if a parameter exists with the same name as the signature parameter. if so use it's value
3. Lastly we search through the provided parameters if we can find a parameter which value has the same type as the signature parameter

The provided parameters are the parameters you provided explicitly with the parameters we find in the current request appended.

### Links that cannot be deduced

Sometimes it is not possible to fully deduce all the links for a resource. In this case, we will try to construct an link as close as possible to the route. We do this by putting the parameters we cannot deduce between brackets.

Let's look at an example: say you want to link an `App\User` to an `App\Post`. The `link` method in your controller expects two parameters `$user` and `$post` with matching types. When the `App\User` is given to the resource but `App\Post` is missing the URL of the link will then look like `/user/link/1/{post}` for the `App\User` with id 1.

This becomes handy to debug which parameters are missing in the resource and should be manually specified for creating links. You can also replace these parameters between brackets on the frontend of your application for a more dynamic link!
