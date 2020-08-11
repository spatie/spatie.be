---
title: The clean up process
weight: 1
---

Over time the number of backups and the storage required to store them will grow. At some point you will want to clean up backups.

To clean up all backups this artisan command can be performed:

```bash
php artisan backup-server:cleanup
```

As mentioned in [the installation instructions](TODO:add link), we recommend scheduling this command to run daily.

## What happens during cleanup

First, for each separate source, a clean up job to [clean up the source](TODO:add link) will be dispatched. After that, for each separate destination, a clean up job to [clean up the destination](TODO: add link) will be dispatched.

## Cleaning up a source

These steps will be performed when cleaning up a source

1. First, all `Backup` models that do not have a directory on the filesystem will be deleted.
2. Next old backups will be deleted. You can read more on we determine that a backup is "old" [in this section](TODO:add link).
3. All backups that are mark as failed (their [backup process](TODO: add link) didn't complete fully) an are older than a day will be deleted.
4. Real backup size will be calculated. Because of the use of hard links in [the backup process](TODO: add link), the size of a backup will not match the size it actually takes on disk. Here, we are going to calculate what the real disk space usage is for each backup and save it in the `real_size_in_kb` on each `Backup`.

## Cleaning up a destination

The package will delete any directory on the destination that does not belong to one of the backups on it.




