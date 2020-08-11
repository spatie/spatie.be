---
title: Working with backups
weight: 4
---

The backups made by this package consist of regular entries in the filesystem. Nothing is zipped (storage space is saved through deduplication and hard links), so you can easily browse the files of all backups. Just head over to the root directory of the disk you configured as the destination disk. The backups are but in separate directories per source.

To help you find the right files, we provide two commands. The first one can find files with a certain name. This is how you would look for all json files in the backups for spatie.be.

```bash
php artisan backup-server:find-files spatie.be *.json
```

You can even search for content. This is how you would search for all files containing the string "Taylor" in all backups for spatie.be

```bash
php artisan backup-server:find-content spatie.be Taylor
```
