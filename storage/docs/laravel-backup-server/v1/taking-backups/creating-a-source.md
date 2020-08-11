---
title: Creating a source
weight: 2
---


The collection of files on a remote server that you wish to backup is represented by a `Source`.

A `Source` is an Eloquent model. It can be created like this.

```php
Destinations\BackupServer\Models\Destination::create($attributes)
```

These attributes can be set

- `name` (required): the name of the host, you can name it anything you'd like
- `host` (required):  the hostname of the server you wish to backup
- `ssh_user`: the user name to use to ssh into the source server
- `ssh_port`: the port to use when connecting to the source server
- `ssh_private_key_file`: the path to a ssh key file to use when connecting to the source server
- `destination_id`: the id of the [destination](TODO: add link) you wish to backup to

- `backup_hour`: the hour on which the `backup-server:dispatch-backups` should create a backup for this source

- `includes`: an array of paths you wish to backup. These can be relative to the home directory of the ssh user, or absolute
- `excludes`: an array of paths you wish to exclude from the backup. These should be relative to the paths giving in `includes`

- `pre_backup_commands`: an array of commands that should be executed on the source server prior to backing up. You could use this to dump the database to the filesystem.
- `post_backup_commands`: an array of commands that should be executed on the source server after the backup is complete. You could use this to clean databases that have been dumped to the filesystem.

The other attributes on the destination are used for [monitoring health](TODO:add link) and [clean up](TODO:add link) of backups.

