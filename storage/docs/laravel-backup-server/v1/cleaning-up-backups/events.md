---
title: Events
weight: 3
---

## `CleanupForSourceCompletedEvent`

This event will be fired when the clean up for a source completed successfully.

It has one public property: `$source`

## `CleanupForSourceFailedEvent`

This event will be fired when the clean up for a source failed.

It has two public properties: `$source` and `$exception.

## `CleanupForDestinationCompletedEvent`

This event will be fired when the clean up for a destination completed successfully.

It has one public property: `$destination`

## `CleanupForDestinationFailedEvent`

This event will be fired when the clean up for a destination failed.

It has two public properties: `$source` and `$exception`.
