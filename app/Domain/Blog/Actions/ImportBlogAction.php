<?php

namespace App\Domain\Blog\Actions;

use App\Domain\Blog\Models\BlogPost;
use Carbon\CarbonImmutable;
use Dom\HTMLDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RuntimeException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\File;

class ImportBlogAction
{
    public function execute(string $directory, bool $dryRun = true): array
    {
        $directory = realpath($directory) ?: throw new RuntimeException('Snapshot directory does not exist.');
        $manifest = json_decode(file_get_contents($this->file($directory, 'manifest.json')), true, flags: JSON_THROW_ON_ERROR);

        if (($manifest['schema_version'] ?? null) !== 1 || empty($manifest['entries'])) {
            throw new RuntimeException('Expected a nonempty version 1 snapshot.');
        }

        Validator::make($manifest, ['source.timezone' => ['required', 'timezone']])->validate();

        if (! empty($manifest['revisions'])) {
            throw new RuntimeException('Source revisions require review before import.');
        }

        $authors = collect($manifest['authors'])->keyBy('id');
        $assets = collect($manifest['assets'])->keyBy('path');
        $posts = collect($manifest['entries']);

        if ($posts->pluck('record.id')->unique()->count() !== $posts->count() || $posts->pluck('record.slug')->unique()->count() !== $posts->count()) {
            throw new RuntimeException('Duplicate source IDs or slugs.');
        }

        foreach ($assets as $asset) {
            $file = $this->file($directory, $asset['file']);
            if (hash_file('sha256', $file) !== $asset['sha256'] || filesize($file) !== $asset['bytes']) {
                throw new RuntimeException("Asset checksum or size mismatch: {$asset['path']}");
            }

            Validator::make(['file' => new File($file)], [
                'file' => ['required', 'file', 'max:30720', 'mimetypes:image/png,image/jpeg,image/gif,image/webp,image/avif,video/mp4,video/webm,application/pdf'],
            ])->validate();
        }

        foreach ($posts as $entry) {
            $record = $entry['record'];
            $data = $record['data'];

            if ($record['collection'] !== 'posts' || $data['product'] !== 'spatie' || $entry['has_working_copy']) {
                throw new RuntimeException('Snapshot contains another product or an unresolved working copy.');
            }

            Validator::make($record, [
                'id' => ['required', 'uuid'],
                'slug' => ['required', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::notIn(['all', 'authors'])],
                'published' => ['required', 'boolean'],
                'data.title' => ['required', 'string', 'max:255'],
                'data.content' => ['required', 'string'],
                'created_at' => ['required', 'date'],
                'updated_at' => ['required', 'date'],
            ])->validate();

            Validator::make($entry, ['date_utc' => [Rule::requiredIf((bool) $record['published']), 'nullable', 'date']])->validate();

            $markdown = file_get_contents($this->file($directory, $entry['markdown_file']));
            if ($markdown !== ($data['content'] ?? '') || hash('sha256', $markdown) !== $entry['markdown_sha256']) {
                throw new RuntimeException("Markdown checksum mismatch: {$record['id']}");
            }

            foreach ($data['authors'] ?? [] as $authorId) {
                if (! $authors->has($authorId) || empty($authors[$authorId]['name'])) {
                    throw new RuntimeException("Missing author: {$authorId}");
                }
            }

            $existing = BlogPost::withTrashed()->where('slug', $record['slug'])->first();
            if ($existing && $existing->source_id !== $record['id']) {
                throw new RuntimeException("Slug already belongs to another post: {$record['slug']}");
            }

            $existing = BlogPost::withTrashed()->where('source_id', $record['id'])->first();
            if ($existing?->source_hash && $existing->source_hash !== $this->fingerprint($entry)) {
                throw new RuntimeException("Source changed after import: {$record['slug']}");
            }

            $mapping = [];
            foreach ($assets as $asset) {
                if (collect($asset['references'])->contains(fn (array $reference) => $reference['entry_id'] === $record['id'])) {
                    $mapping += $this->replacements($asset['path'], 'https://import.invalid/'.hash('sha256', $asset['path']));
                }
            }
            $this->assertResolved(strtr($markdown."\n\n".($data['summary'] ?? ''), $mapping));

            foreach (['header_image', 'og_image'] as $field) {
                if (! empty($data[$field]) && ! $assets->has($this->assetPath($data[$field]))) {
                    throw new RuntimeException("Missing {$field} for {$record['slug']}");
                }
            }
        }

        $imported = 0;
        $skipped = 0;

        foreach ($posts as $entry) {
            $record = $entry['record'];
            $data = $record['data'];
            $post = BlogPost::withTrashed()->where('source_id', $record['id'])->first();

            if ($post?->source_hash || $post?->trashed()) {
                if (! $post->trashed()) {
                    foreach ($post->media as $media) {
                        $this->verifyMedia($media);
                    }
                }
                $skipped++;

                continue;
            }

            if ($dryRun) {
                $imported++;

                continue;
            }

            $post ??= BlogPost::create(['source_id' => $record['id'], 'slug' => $record['slug'], 'title' => $data['title']]);
            $mapping = [];

            foreach ($assets as $asset) {
                if (! collect($asset['references'])->contains(fn (array $reference) => $reference['entry_id'] === $record['id'])) {
                    continue;
                }

                $media = $this->importMedia($post, $directory, $asset, 'attachments');
                $mapping += $this->replacements($asset['path'], $media->getUrl());
            }

            foreach (['header_image' => 'header', 'og_image' => 'og'] as $field => $collection) {
                if (! empty($data[$field])) {
                    $this->importMedia($post, $directory, $assets[$this->assetPath($data[$field])], $collection);
                }
            }

            $markdown = strtr($data['content'] ?? '', $mapping);
            $summary = strtr($data['summary'] ?? '', $mapping);
            $this->assertResolved($markdown."\n\n".$summary);

            $tags = collect($data['tags'] ?? [])->map(function (string $tag) use ($manifest): string {
                $term = collect($manifest['tags'])->first(fn ($term) => is_array($term) && ($term['id'] ?? $term['slug'] ?? null) === $tag);

                return $term['title'] ?? $term['data']['title'] ?? $tag;
            })->all();

            app(SaveBlogPostAction::class)->execute($post, [
                'title' => $data['title'],
                'markdown' => $markdown,
                'summary_markdown' => $summary,
                'author_data' => collect($data['authors'] ?? [])->map(fn (string $id) => [
                    'name' => $authors[$id]['name'],
                    'gravatar_url' => $authors[$id]['gravatar_url'] ?? '',
                ])->all(),
                'tags' => $tags,
                'published' => (bool) $record['published'],
                'published_at' => $entry['date_utc'] ? CarbonImmutable::parse($entry['date_utc'], 'UTC')->setTimezone(config('app.timezone')) : null,
            ]);

            $post->forceFill([
                'source_hash' => $this->fingerprint($entry),
                'created_at' => CarbonImmutable::parse($record['created_at'], $manifest['source']['timezone'])->setTimezone(config('app.timezone')),
                'updated_at' => CarbonImmutable::parse($record['updated_at'], $manifest['source']['timezone'])->setTimezone(config('app.timezone')),
            ])->saveQuietly();
            $imported++;
        }

        return ['imported' => $imported, 'skipped' => $skipped, 'assets' => $assets->count(), 'dry_run' => $dryRun];
    }

    protected function importMedia(BlogPost $post, string $directory, array $asset, string $collection): Media
    {
        $existing = $post->media()->where('collection_name', $collection)->where('custom_properties->source_path', $asset['path'])->first();
        if ($existing && ! Storage::disk($existing->disk)->exists($existing->getPathRelativeToRoot())) {
            $existing->delete();
            $existing = null;
        }

        if ($existing) {
            $this->verifyMedia($existing);

            return $existing;
        }

        $media = app(AddBlogMediaAction::class)->execute($post, $this->file($directory, $asset['file']), $collection, [
            'source_path' => $asset['path'],
            'original_name' => basename($asset['path']),
            'source_metadata' => $asset['metadata'] ?? [],
        ]);
        $this->verifyMedia($media);

        return $media;
    }

    protected function verifyMedia(Media $media): void
    {
        $stream = Storage::disk($media->disk)->readStream($media->getPathRelativeToRoot());
        if (! is_resource($stream)) {
            throw new RuntimeException("Cannot read imported media {$media->id}.");
        }

        try {
            $hash = hash_init('sha256');
            hash_update_stream($hash, $stream);
            if (hash_final($hash) !== $media->getCustomProperty('sha256')) {
                throw new RuntimeException("Stored media checksum mismatch: {$media->id}");
            }
        } finally {
            fclose($stream);
        }
    }

    protected function file(string $directory, string $relative): string
    {
        $path = realpath($directory.'/'.$relative);
        if (! $path || ! str_starts_with($path, $directory.'/') || ! is_file($path)) {
            throw new RuntimeException('Missing or unsafe snapshot file.');
        }

        return $path;
    }

    protected function fingerprint(array $entry): string
    {
        return hash('sha256', json_encode($entry['record'], JSON_THROW_ON_ERROR));
    }

    protected function assetPath(string $value): string
    {
        return rawurldecode(preg_replace('~^(?:statamic://asset::assets::|https?://content\.spatie\.be/assets/|/assets/)~', '', $value));
    }

    protected function replacements(string $path, string $url): array
    {
        $encoded = implode('/', array_map('rawurlencode', explode('/', $path)));
        $mapping = [];
        foreach (array_unique([$path, $encoded]) as $variant) {
            foreach (['https://content.spatie.be/assets/', 'http://content.spatie.be/assets/', '/assets/', 'statamic://asset::assets::'] as $prefix) {
                $mapping[$prefix.$variant] = $url;
            }
        }

        return $mapping;
    }

    protected function assertResolved(string $markdown): void
    {
        $html = app(RenderBlogMarkdownAction::class)->execute($markdown);
        $document = HTMLDocument::createFromString('<!DOCTYPE html><html><body>'.$html.'</body></html>', LIBXML_NOERROR, 'UTF-8');
        foreach ($document->querySelectorAll('[src], [href], [poster], [srcset]') as $element) {
            foreach (['src', 'href', 'poster', 'srcset'] as $attribute) {
                $value = $element->getAttribute($attribute);
                if (preg_match('~(?:content\.spatie\.be/(?:assets|img)/|(?:^|[\s,])/assets/|statamic://asset::)~', $value)) {
                    throw new RuntimeException('Unresolved source media reference in rendered content.');
                }
            }
        }
    }
}
