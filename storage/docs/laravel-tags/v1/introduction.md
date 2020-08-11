---
title: Introduction
weight: 1
---

This package offers taggable behaviour for your models. After the package is installed the only thing you have to do is to add the `HasTags` trait to an Eloquent model to make it taggable. 

But we didn't stop with the regular tagging capabilities you find in every package. Laravel Tags comes with batteries included. Out of the box it has support for [translating tags](/laravel-tags/v1/advanced-usage/adding-translations), [multiple tag types](/laravel-tags/v1/advanced-usage/using-types) and [sorting capabilities](/laravel-tags/v1/advanced-usage/sorting-tags).

Here are some code examples:

```php
//create a model with some tags
$newsItem = NewsItem::create([
   'name' => 'testModel',
   'tags' => ['tag', 'tag2'], //tags will be created if they don't exist
]);

//attaching tags
$newsItem->attachTag('tag3');
$newsItem->attachTags(['tag4', 'tag5']);

//detaching tags
$newsItem->detachTag('tag3');
$newsItem->detachTags(['tag4', 'tag5']);

//syncing tags
$newsItem->syncTags(['tag1', 'tag2'); // all other tags on this model will be detached

//retrieving models that have any of the given tags
NewsItem::withAnyTags(['tag1', 'tag2']);

//retrieve models that have all of the given tags
NewsItem::withAllTags(['tag1', 'tag2']);

//translating a tag
$tag = Tag::findOrCreate('my tag');
$tag->setTranslation('fr', 'mon tag');
$tag->setTranslation('nl', 'mijn tag');
$tag->save();

//using tag types
$tag = Tag::create('tag 1', 'my type');

//tags have slugs
$tag = Tag::create('yet another tag');
$tag->slug; //returns "yet-another-tag"

//tags are sortable
$tag = Tag::findOrCreate('my tag');
$tag->order_column; //returns 1
$tag2 = Tag::findOrCreate('another tag');
$tag2->order_column; //returns 2

//manipulating the order of tags
$tag->swapOrder($anotherTag);
```

## We have badges!

<section class="article_badges">
    <a href="https://packagist.org/packages/spatie/laravel-tags"><img src="https://img.shields.io/packagist/v/spatie/laravel-tags.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/spatie/laravel-tags/blob/master/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://travis-ci.org/spatie/laravel-tags"><img src="https://img.shields.io/travis/spatie/laravel-tags/master.svg?style=flat-square" alt="Build Status"></a>
    <a href="https://insight.sensiolabs.com/projects/b9e28680-fffe-4e6f-90fa-8c83417f6a86"><img src="https://img.shields.io/sensiolabs/i/b9e28680-fffe-4e6f-90fa-8c83417f6a86.svg?style=flat-square" alt="SensioLabsInsight"></a>
    <a href="https://scrutinizer-ci.com/g/spatie/laravel-tags"><img src="https://img.shields.io/scrutinizer/g/spatie/laravel-tags.svg?style=flat-square" alt="Quality Score"></a>
    <a href="https://packagist.org/packages/spatie/laravel-tags"><img src="https://img.shields.io/packagist/dt/spatie/laravel-tags.svg?style=flat-square" alt="Total Downloads"></a>
</section>
