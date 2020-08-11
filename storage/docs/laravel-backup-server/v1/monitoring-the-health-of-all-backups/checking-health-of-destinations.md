---
title: Checking health of destinations
weight: 3
---

Checking the health of a source is done by `DestinationHealthCheck` classes configured in the `monitor.destination_health_checks` key of the `backup-server` config file.

The package ships with these two checks configured by default:
- `DestinationReachable`: if the disk set in the `disk_name` attribute doesn't exist anymore, the destination will be considered unhealthy
- `MaximumDiskCapacityUsageInPercentage`: if the used capacity percentage is higher than the configure value, the destination will be considered unhealthy
- `MaximumStorageInMB` => if the used storage in MB for this destination is higher than the configured value, the destination will be considered unhealthy. You can disable this check by setting the value to 0.
- `MaximumInodeUsageInPercentage`: each filesystem has a maximum amount of entries. These entries are called inodes. If the used inode percentage is higher than the configured value, the destination will be considered unhealthy.

## Creating health checks of your own

In the `monitor.destination_health_checks` key of the `backup-server` config file you can add health check classes of your own. Any class you add there should extend `Spatie\BackupServer\Tasks\Monitor\HealthChecks\Source\SourceHealthCheck`. Here is how that abstract class is defined.

```php
namespace Spatie\BackupServer\Tasks\Monitor\HealthChecks\Destination;

use Spatie\BackupServer\Models\Destination;
use Spatie\BackupServer\Tasks\Monitor\HealthCheckResult;
use Spatie\BackupServer\Tasks\Monitor\HealthChecks\HealthCheck;

abstract class DestinationHealthCheck extends HealthCheck
{
    abstract public function getResult(Destination $destination): HealthCheckResult;
}
```

## Get notifications of (un)healthy destinations

You can receive notifications when the monitor finds an (un)healthy destinations. 
Read the section on [notifications](TODO: add link) to learn more.
                            
