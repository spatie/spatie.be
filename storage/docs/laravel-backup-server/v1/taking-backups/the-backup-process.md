---
title: The backup process
weight: 3
---

When creating a backup, these steps will be performed. 

## 1. Ensuring that the source is reachable

The package will try to log in the source server and perform the `whoami` command. If that succeeds, the source is considered reachable.
If that fails, the backup process will stop.

## 2. Ensuring that the destination is reachable

The package will verify if the `disk_name` on the `Destination` matches a disk defined in `config/filesystems.php`. If the disk does not exist, the backup process will stop.

## 3. Determining the destination directory

On the destination disk a directory will be created with this format:

`/<source-id>/<backup-<date-in-YmdHis-format>`

If that directory could not be created - you know the drill by now - the backup process will stop.

## 4. Perform pre-backup commands

On a `Source` you can save an array with unix commands `pre_backup_commands`. These commands will now be executed on the source. You could add a command here to dump your database to the filesystem, so it will be backed up too.
 
If one of these commands fail, the backup process will stop.

## 5. Running the actual backup.

Finally, we have arrived to the holy grail of this package: taking an actual backup. Under the hood, `rsync` is used to copy all files and directories specified in the `includes` array on the `Source`. Files and directories in the `excludes` array of the `Source` will be excluded.  

If the backup isn't the initial one, than `rsync` will take in account the previous backup. Only files that are new or changed will be copied to the destination directory of the backup. Files that are identical to the ones in the previous backup, will not be copied. Instead, `rsync` will put a hard link to the file in the previous backup. This means that, even though a file will appear in your filesystem, no real disk space will be used. 

When the previous backup will be deleted, the hard links will still work. The filesystem is smart enough to know that there is still an entry in the filesystem pointing to the space on the hard disk and the space will not be freed.

Should `rsync` fail, the backup process will stop

## 6. Perform post-backup commands

On a `Source` you can save an array with unix commands `post_backup_commands`. These commands will now be executed on the source. You could add a command here to delete and old db dumps from the filesystem.

If one of these commands fail, the backup process will stop.

## 7. Calculate backup size

The total size of the backup will now be calculated and save in the `size_in_kb` attribute on the `Source`. This size in the total if you were to copy all these files to another disk. On your backup disk it could be, due to the use of hard link, that the actually used space on disk is much lower.
