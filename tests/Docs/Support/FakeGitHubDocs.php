<?php

namespace Tests\Docs\Support;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;

class FakeGitHubDocs
{
    /** @var array<string, string> */
    protected array $commitPerBranch = [];

    /** @var array<string, array<string, string>> */
    protected array $docsPerCommit = [];

    /** @var array<int, string> */
    protected array $failingBranches = [];

    /** @var array<int, string> */
    protected array $failingFiles = [];

    /** @var array<string, callable> */
    protected array $beforeResponding = [];

    public static function make(): self
    {
        Sleep::fake();

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
        $commit = sha1($repository . $branch . serialize($docs));

        $this->commitPerBranch["{$repository}@{$branch}"] = $commit;
        $this->docsPerCommit[$commit] = $docs;

        return $this;
    }

    public function failingBranch(string $repository, string $branch): self
    {
        $this->failingBranches[] = "{$repository}@{$branch}";

        return $this;
    }

    public function failingFile(string $path): self
    {
        $this->failingFiles[] = $path;

        return $this;
    }

    public function beforeResponding(string $repository, string $branch, callable $callback): self
    {
        $this->beforeResponding["{$repository}@{$branch}"] = $callback;

        return $this;
    }

    protected function respond(Request $request): PromiseInterface
    {
        $url = Str::before($request->url(), '?');

        if (str_starts_with($url, 'https://raw.githubusercontent.com/')) {
            return $this->respondWithFile(Str::after($url, 'https://raw.githubusercontent.com/'));
        }

        if (str_contains($url, '/git/trees/')) {
            return $this->respondWithTree(Str::after($url, '/git/trees/'));
        }

        return $this->respondWithBranch(
            Str::between($url, 'https://api.github.com/repos/', '/branches/'),
            Str::after($url, '/branches/'),
        );
    }

    protected function respondWithBranch(string $repository, string $branch): PromiseInterface
    {
        $key = "{$repository}@{$branch}";

        if (isset($this->beforeResponding[$key])) {
            ($this->beforeResponding[$key])();
        }

        if (in_array($key, $this->failingBranches)) {
            return Http::response('Server error', 500);
        }

        if (! isset($this->commitPerBranch[$key])) {
            return Http::response(['message' => 'Branch not found'], 404);
        }

        return Http::response(['name' => $branch, 'commit' => ['sha' => $this->commitPerBranch[$key]]]);
    }

    protected function respondWithTree(string $commit): PromiseInterface
    {
        $docsEntries = collect($this->docsPerCommit[$commit])
            ->keys()
            ->map(fn (string $path) => ['path' => "docs/{$path}", 'mode' => '100644', 'type' => 'blob']);

        $otherEntries = collect([
            ['path' => 'README.md', 'mode' => '100644', 'type' => 'blob'],
            ['path' => 'src', 'mode' => '040000', 'type' => 'tree'],
            ['path' => 'src/Package.php', 'mode' => '100644', 'type' => 'blob'],
            ['path' => 'docs', 'mode' => '040000', 'type' => 'tree'],
            ['path' => 'docs/symlink.md', 'mode' => '120000', 'type' => 'blob'],
        ]);

        return Http::response([
            'sha' => $commit,
            'tree' => $otherEntries->merge($docsEntries)->all(),
            'truncated' => false,
        ]);
    }

    protected function respondWithFile(string $path): PromiseInterface
    {
        [$owner, $repository, $commit] = explode('/', $path);

        $docsPath = rawurldecode(Str::after($path, "{$owner}/{$repository}/{$commit}/docs/"));

        if (in_array($docsPath, $this->failingFiles)) {
            return Http::response('Server error', 500);
        }

        if (! isset($this->docsPerCommit[$commit][$docsPath])) {
            return Http::response('Not found', 404);
        }

        return Http::response($this->docsPerCommit[$commit][$docsPath]);
    }
}
