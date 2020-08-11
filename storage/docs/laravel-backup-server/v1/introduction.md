---
title: Introduction
weight: 1
---

**THIS PACKAGE IS NOT RELEASED / PUBLISHED YET, WE WILL MAKE IT AVAILABLE SOON**

This package backs up one or more servers that use either the `ext3` or `ext4` filesystem, which is the default file system for many *nix distributions. When a backup contains files also present in a previous backup, deduplication using hard links will be performed. Even though you will see full backups in the filesystem, only changed files will take up disk space.

The package can also search for file names and content in backups, clean up old backups, and notify you when there were problems running the backups.

## We have badges!

<section class="article_badges">
    <a href="https://github.com/spatie/laravel-backup-server/releases"><img src="https://img.shields.io/github/release/spatie/laravel-backup-server.svg?style=flat-square" alt="Latest Version"></a>
    <a href="https://github.com/spatie/laravel-backup-server/blob/master/LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://packagist.org/packages/spatie/laravel-backup-server"><img src="https://img.shields.io/packagist/dt/spatie/laravel-backup-server.svg?style=flat-square" alt="Total Downloads"></a>
</section>
