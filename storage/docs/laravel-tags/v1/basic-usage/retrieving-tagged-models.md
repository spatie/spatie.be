---
title: Retrieving tagged models
weight: 2
---

The package provides two scopes `withAnyTags` and `withAllTags` that can help you find models with certain tags.

### withAnyTags

The `withAnyTags` scope will return models that have one or more of the given tags attached to them.

```php
//returns models that have one or more of the given tags
YourModel::withAnyTags(['tag 1', 'tag 2'])->get();

//returns models that have one or more of the given tags that are typed `myType`
YourModel::withAnyTags(['tag 1', 'tag 2'], 'myType')->get();
```

### withAllTags

The `withAllTags` scope will return only the models that have all of the given tags attached to them. So when passing a non-existing tag no models will be returned.

```
//returns models that have all given tags
YourModel::withAllTags(['tag 1', 'tag 2'])->get();

//returns models that have all given tags that are typed `myType`
YourModel::withAllTags(['tag 1', 'tag 2'], 'myType')->get();
```
