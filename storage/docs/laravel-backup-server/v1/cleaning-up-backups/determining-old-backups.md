---
title: Determining old backups
weight: 2
---

As part of [the cleanup process](TODO: add link), old backups will be deleted. But how does the package determine whether a backup is "old".

This package provides an opinionated method to determine which old backups should be deleted. We call this the `DefaultStrategy`. This is how it works.

- Rule #1: it will never delete the latest backup regardless of its size or age
- Rule #2: it will keep all backups for the number of days specified in `keep_all_backups_for_days`
- Rule #3: it will only keep daily backups for the number of days specified in `keep_daily_backups_for_days` for all backups older than those covered by rule #2
- Rule #4: it will only keep weekly backups for the number of months specified in `keep_weekly_backups_for_weeks` for all backups older than those covered by rule #3
- Rule #5: it will only keep weekly backups for the number of months specified in `keep_monthly_backups_for_months` for all backups older than those covered by rule #4
- Rule #6: it'll only keep yearly backups for the number of years specified in `keep_yearly_backups_for_years` for all backups older than those covered by rule #5
- Rule #7: it will start deleting old backups until the volume of storage used is lower than the amount specified in `delete_oldest_backups_when_using_more_megabytes_than`.

Those `keep-*` and `delete_oldest_backups_when_using_more_megabytes_than` attributes are present on the source and on the destination of backup and in the `cleanup.default_strategy` key of the `backup-server` config file.

First, cleanup process will try if the attribute is filled on the source, if not, it will look on the destination. When it's not filled in the destination it will use the value in the config file. 
