<?php

namespace App\Console\Commands;

use App\Domain\Shop\Actions\RegenerateLeakedLicenseKeyAction;
use App\Domain\Shop\Models\License;
use App\Services\GitHub\GitHubApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use phpseclib3\Math\BigInteger\Engines\PHP;

class RegenerateLeakedKeysCommand extends Command
{
    protected $signature = 'regenerate-leaked-keys';

    public function handle(GitHubApi $gitHubApi)
    {
        [$paginator, $response] = $gitHubApi->search('satis.spatie.be');

        do {
            foreach($response['items'] as $result)
            {
                $this->processResult($result);
            }

            sleep(60);
        } while($response = $paginator->fetchNext());
    }

    public function processResult(array $result): void
    {
        if ($result['name'] !== 'auth.json') {
            return;
        }

        if ($result['repository']['private']) {
            return;
        }

        $jsonContent = $this->getJsonContent($result['url']);

        if (! $jsonContent) {
            return;
        }

        $licenseKey = $jsonContent['http-basic']['satis.spatie.be']['password'] ?? false;

        if (! $licenseKey) {
            return;
        }
        if (! $license = License::where('key', $licenseKey)->first()) {
            return;
        }

        (new RegenerateLeakedLicenseKeyAction())->execute($license, $result['html_url']);

    }

    protected function getJsonContent(string $url): ?array
    {
        $fileUrls = Http::asJson()->get($url);

        $rawContent = Http::get($fileUrls['download_url'])->body();

        return json_decode($rawContent, true);
    }
}
