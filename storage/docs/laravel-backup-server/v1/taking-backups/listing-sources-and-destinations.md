---
title: Listing sources and destinations
weight: 4
---

You can list all sources like this:

```bash
php artisan backup-server:list
```

Per source you'll see if it is healthy, the number of backups, the age of the latest backup, the total storage used, and more.

You can list all destinations with this command:

```bash
backup-server:list-destinations
```

Per destination you'll see if is healthy, the total capacity used, the percentage of inodes used, and more.

