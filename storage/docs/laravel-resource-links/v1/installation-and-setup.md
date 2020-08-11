---
title: Installation and setup
weight: 3
---

## Basic installation

You can install this package via composer:

```bash
composer require spatie/laravel-resource-links
```

The package will automatically register a service provider.

Publishing the config file is optional:

```bash
php artisan vendor:publish --provider="Spatie\ResourceLinks\ResourceLinksServiceProvider" --tag="config"
```

This is the default content of the config file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Serializer
    |--------------------------------------------------------------------------
    |
    | The serializer will be used for the conversion of links to their array
    | representation, when no serializer is explicitly defined for an link
    | resource this serializer will be used.
    |
    */

    'serializer' => Spatie\ResourceLinks\Serializers\LinkSerializer::class,
];
```
