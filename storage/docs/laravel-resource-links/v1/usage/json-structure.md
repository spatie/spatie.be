---
title: Json structure
weight: 6
---

Want to change how links are structured in your resources? You can use serializers to output links different formats and even write your own custom serializes!

You can specify the serializer to be used in the config file of the package.

On a default installation we use the `LinkSerializer`:

```json
"links": {
    "index": "https://laravel.app/users",
    "update": "https://laravel.app/users/1",
}
```

Want to include the http verb of a link? Then take a look at the `ExtendedLinkSerializer`:

```json
"links": {
    "index": {
        'method': 'get',
        'action': "https://laravel.app/users"
    },
    "update": {
        'method': 'put',
        'action': "https://laravel.app/users/1"     
    },
}
```

Want prefixes in separate objects? No problem, use the `LayeredExtendedLinkSerializer`! Normally a prefixed link would look like this

```json
"links": {
    "index": {
        'method': 'get',
        'action': "https://laravel.app/users"
    },
    "actions.update": {
        'method': 'put',
        'action': "https://laravel.app/users/1"     
    },
}
```

With the `LayeredExtendedLinkSerializer` it will look like this:

```json
"links": {
    "index": {
        'method': 'get',
        'action': "https://laravel.app/users"
    },
    "actions"{
        "update": {
            'method': 'put',
            'action': "https://laravel.app/users/1"     
        }
    }
}
```

### Using serializers

The default serializer for a project can be set in the `resource-links.php` config file. If you are using link groups, it is possible to set a serializer specifically for each link:
                                                                                     
 ```php
 $links
     ->controller(UsersController::class)
     ->serializer(Spatie\LaravelResourceLinks\Serializers\LayeredExtendedLinkSerializer::class);
 ```

## Creating your own serializers

You can create serializers by implementing the `Spatie\ResourceLinks\Serializers\Serializer` interface:

```php
interface Serializer
{
    public function format(LinkContainer $linkContainer): array;
}
```

The `LinkContainer` contains information about the link like:

- name: the name of the link (`index`, `update` ...)
- method: the http verb of the link
- action: the url of the link
- prefix: a prefix used by the user for the link
