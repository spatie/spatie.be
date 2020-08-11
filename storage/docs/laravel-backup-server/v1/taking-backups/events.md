---
title: Events
weight: 4
---

## `Spatie\BackupServer\Tasks\Backup\Events\BackupCompletedEvent`

This event will be fired after the entire backup process has been completed. It has a public property `$backup` which is an instance of `Spatie\BackupServer\Models\Backup`

## `Spatie\BackupServer\Tasks\Backup\Events\BackupFailedEvent`

This event will be fired after one of the steps of the backup process failed. It has a public property `$backup` which is an instance of `Spatie\BackupServer\Models\Backup`.
