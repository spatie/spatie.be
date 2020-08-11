---
title: Checking health of sources
weight: 2
---

Checking the health of a source is done by `SourceHealthCheck` classes configured in the `monitor.source_health_checks` key of the `backup-server` config file.

The package ships with these two checks configured by default:
- `MaximumStorageInMB`: this check will fail if the total size of your backups is greater that the specified amount of megabytes. You can override the the maximum amount of megabytes in the config file by filling the `healthy_maximum_storage_in_mb` attribute on a `Destination`. You can override that value defined on a `Destination` by settings the `healthy_maximum_storage_in_mb` on a source.
- `MaximumAgeInDays`: this check will fail if the age of the youngest back is older than the given amount of days. You can override the the agi in the days in the config file by filling the `healthy_maximum_backup_age_in_days` attribute on a `Destination`. You can override that value defined on a `Destination` by settings the `healthy_maximum_backup_age_in_days` on a source.

## Creating health checks of your own

In the `monitor.source_health_checks` key of the `backup-server` config file you can add health check classes of your own. Any class you add there should extend `Spatie\BackupServer\Tasks\Monitor\HealthChecks\Source\SourceHealthCheck`. Here is how that abstract class is defined.

```php
namespace Spatie\BackupServer\Tasks\Monitor\HealthChecks\Source;

use Spatie\BackupServer\Models\Source;
use Spatie\BackupServer\Tasks\Monitor\HealthCheckResult;
use Spatie\BackupServer\Tasks\Monitor\HealthChecks\HealthCheck;

abstract class SourceHealthCheck extends HealthCheck
{
    abstract public function getResult(Source $source): HealthCheckResult;
}
```

## Get notifications of (un)healthy sources

You can receive notifications when the monitor finds an (un)healthy sources. 
Read the section on [notifications](TODO: add link) to learn more.
                            

                      
