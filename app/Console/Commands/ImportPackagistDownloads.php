<?php

namespace App\Console\Commands;

use App\Models\Repository;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Spatie\Packagist\Packagist;

class ImportPackagistDownloads extends Command
{
    protected $signature = 'import:packagist-downloads';

    protected $description = 'Import download counts of packages.';

    public function handle()
    {
        $this->info('Importing downloads from Packagist...');

        $client = new Client();

        $packagist = new Packagist($client);

        collect($packagist->getPackagesByVendor('spatie')['packageNames'])
            ->map(function ($packageName) use ($packagist) {
                return $packagist->findPackageByName($packageName)['package'];
            })
            ->each(function ($package) {
                $name = explode('/', $package['name'])[1];

                $this->comment("Getting downloads for `{$name}`");

                $downloadCount = $package['downloads']['total'];

                Repository::where('name', $name)->update(['downloads' => $downloadCount]);
            });

        $this->info('All done!');
    }
}
