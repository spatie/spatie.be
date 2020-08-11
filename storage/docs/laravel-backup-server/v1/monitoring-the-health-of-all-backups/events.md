---
title: Events
weight: 4
---

## HealthySourceFoundEvent

This event will be fired when a healthy backup is found.

It has one public property: `$source`

## UnhealthySourceFoundEvent

This event will be fired when a unhealthy backup is found.

It has two public properties: `$source` and `$failureMessages`, which is an array.

## HealthyDestinationFoundEvent

It has one public property: `$destination`

This event will be fired when a healthy destination is found.

## UnhealthyDestinationFoundEvent

This event will be fired when a unhealthy destination is found.

It has two public properties: `$destination` and `$failureMessages`, which is an array.
