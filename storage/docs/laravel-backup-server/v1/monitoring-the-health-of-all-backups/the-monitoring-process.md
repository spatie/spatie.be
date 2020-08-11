---
title: The monitoring process
weight: 1
---

The package can check the health of backups for every source, and the destination is healthy.

This check happens in the `backup-server:monitor` command that should be scheduled as shown in [the installation instructions](TODO: add link).

This check will [fires of events](TODO: add link) and [sends out notifications](TODO: add link) for each (un)healthy source and destination.
