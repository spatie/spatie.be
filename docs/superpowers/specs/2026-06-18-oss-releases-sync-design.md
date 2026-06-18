# OSS package releases sync

## Goal

Pull GitHub releases and git tags for all Spatie **packages** into a new structured table, refreshed daily and incrementally via a scheduled command. Add a read-only internal view in the Filament admin panel so the team can see what shipped recently.

Out of scope for now: a public, curated website feed (a future step).

## Scope decisions

- **Deliverable:** data sync (DB + cron) + a read-only Filament admin view.
- **Captured data:** both GitHub releases and git tags. A release where available (rich notes), otherwise a tag-only entry.
- **Repositories:** only `package` type rows from the existing `repositories` table (`Repository::packages()`).
- **Frequency:** daily, incremental.

## Data model

New table `repository_releases`, model `App\Models\RepositoryRelease`. One row per tag per package.

| Column | Purpose |
|---|---|
| `id` | PK |
| `repository_id` | FK → `repositories`, cascade on delete |
| `tag_name` | e.g. `10.0.1` or `v2.3.0` (raw tag) |
| `name` | release title (null for tag-only) |
| `body` | release notes / changelog markdown (null for tag-only) |
| `url` | html URL of the release, or the tag's GitHub URL |
| `commit_sha` | the tag/release target commit |
| `is_release` | bool, true if a GitHub Release exists, false if tag-only |
| `is_prerelease` | bool |
| `released_at` | release `published_at`, or the tag commit date for tag-only |
| `created_at` / `updated_at` | timestamps |

- Unique index on `(repository_id, tag_name)`.
- Index on `released_at` for "recent" ordering.
- `Repository hasMany RepositoryRelease`; `RepositoryRelease belongsTo Repository`.

## Fetching

Extend `App\Services\GitHub\GitHubApi` (knplabs/github-api) with pure API methods returning raw arrays:

- `fetchReleases(string $repository): Collection` — all releases (paginated).
- `fetchTags(string $repository): Collection` — all tags (paginated).
- `fetchCommitDate(string $repository, string $sha): Carbon` — committer date for a tag's commit (only needed to date tag-only entries).

## Sync logic

`App\Actions\ImportRepositoryReleasesAction::execute(Repository $repository): void`

1. Fetch releases. Skip drafts. For each, `updateOrCreate` keyed on `(repository_id, tag_name)` with `is_release = true`, `name`, `body`, `url`, `is_prerelease`, `released_at = published_at`, `commit_sha`.
2. Fetch tags. For any tag whose row does not already exist (after step 1), create a tag-only row (`is_release = false`), using `fetchCommitDate` for `released_at`.

Incrementality: releases use idempotent `updateOrCreate`; commit-date lookups only happen for genuinely new tag-only versions, so steady-state daily runs do no extra per-tag work and no writes when nothing changed.

## Command & schedule

`App\Console\Commands\ImportGitHubReleasesCommand` (`import:github-releases`): iterate `Repository::packages()->get()`, call the action per package with progress output. Schedule `dailyAt` in `app/Console/Kernel.php`.

## Internal view

Read-only `RepositoryReleaseResource` (Filament, "Content" group). Index page only, no create/edit/delete. Columns: repository name, tag, title, is_release, is_prerelease, released_at. Default sort `released_at` desc. Searchable on tag and repository name.

## Testing

Pest tests for the action (releases imported, tag-only imported with commit date, drafts skipped, idempotent re-run) and the command (runs for packages only), using a mocked `GitHubApi`.
