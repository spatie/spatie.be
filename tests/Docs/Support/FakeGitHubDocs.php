<?php

namespace Tests\Docs\Support;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FakeGitHubDocs
{
    /** @var array<string, array<string, string>> */
    protected array $docsPerBranch = [];

    /** @var array<int, string> */
    protected array $failingBranches = [];

    /** @var array<string, callable> */
    protected array $beforeResponding = [];

    public static function make(): self
    {
        $fakeGitHubDocs = new self();

        Http::fake(fn (Request $request) => $fakeGitHubDocs->respond($request));

        return $fakeGitHubDocs;
    }

    /** @return array<string, string> */
    public static function docsForVersion(string $version, string $introduction = 'Introduction text'): array
    {
        return [
            '_index.md' => "---\ntitle: {$version}\nslogan: Backups made easy\ngithubUrl: https://github.com/spatie/laravel-backup\nbranch: main\n---\n",
            'introduction.md' => "---\ntitle: Introduction\nweight: 1\n---\n\n{$introduction}\n",
            'basic-usage/_index.md' => "---\ntitle: Basic usage\nweight: 2\n---\n",
            'basic-usage/taking-backups.md' => "---\ntitle: Taking backups\nweight: 1\n---\n\nRun the backup command.\n",
            'images/header.png' => 'png contents',
        ];
    }

    /** @param array<string, string> $docs */
    public function branch(string $repository, string $branch, array $docs): self
    {
        $this->docsPerBranch["{$repository}@{$branch}"] = $docs;

        return $this;
    }

    public function failingBranch(string $repository, string $branch): self
    {
        $this->failingBranches[] = "{$repository}@{$branch}";

        return $this;
    }

    public function beforeResponding(string $repository, string $branch, callable $callback): self
    {
        $this->beforeResponding["{$repository}@{$branch}"] = $callback;

        return $this;
    }

    protected function respond(Request $request): PromiseInterface
    {
        $repository = Str::between($request->url(), 'https://api.github.com/repos/', '/zipball/');
        $branch = Str::after($request->url(), '/zipball/');

        $key = "{$repository}@{$branch}";

        if (isset($this->beforeResponding[$key])) {
            ($this->beforeResponding[$key])();
        }

        if (in_array($key, $this->failingBranches)) {
            return Http::response('Server error', 500);
        }

        if (! isset($this->docsPerBranch[$key])) {
            return Http::response(['message' => 'Not Found'], 404);
        }

        $files = collect($this->docsPerBranch[$key])
            ->mapWithKeys(fn (string $contents, string $path) => ["docs/{$path}" => $contents])
            ->put('README.md', '# Readme')
            ->put('src/Package.php', '<?php')
            ->all();

        return Http::response(Zipball::make($files));
    }
}
