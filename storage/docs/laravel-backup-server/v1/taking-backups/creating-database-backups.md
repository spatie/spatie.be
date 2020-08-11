---
title: Creating database backups
weight: 6
---

This package cannot create database backups. It will only backup files on remote servers. 

You can however, define `pre_backup_commands` for each source. The commands will be executed right before taking a backup. You could use this to dump the database on a remote server to the remote server, so that it will be backed up. In the `post_backup_commands` of a source you could add a command that removes the dump from the filesystem of the remote server.

