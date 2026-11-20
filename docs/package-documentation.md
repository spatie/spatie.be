# Package documentation

`config/docs.php` registers each package's GitHub repository, documentation category,
and branch-to-version mapping. The docs index groups these packages by category;
`PHP` and `General PHP` share one PHP section. Rust packages appear at `/docs#rust`.
The existing package catalogue at `/open-source/packages` uses visible database
repositories, independently of this documentation registry.

## Adding a Rust package

Add an entry to `config/docs.php` with category `Rust`. For example, `rust-crawler`
imports `spatie/rust-crawler`'s `main` branch as `v0.2`. Its introduction is served at
`/docs/rust-crawler/v0.2/introduction`; `/docs/rust-crawler` redirects there.

Keep the guide in the package repository's `docs/` directory, not in this website.
The importer fetches files through GitHub's API, writes a complete release to the
configured docs disk, activates it, and refreshes the package's cache. Assets use
the separate docs-assets disk. Navigation, Markdown responses and
`/docs/{package}/{version}/llms.txt` use the existing docs routes. Full-text search
uses the site's existing crawl/index pipeline; importing docs does not reindex it.

The guide's `docs/_index.md` must contain `title` matching the configured version
alias, `slogan`, `githubUrl`, and `branch`. Pages and section `_index.md` files use
`title` and `weight` frontmatter. Relative `.md` links are rendered as HTML page
links, preserving fragments and query strings. Rustdoc fences such as
`rust,no_run` render as Rust code blocks; the current highlighter falls back to
plain, escaped code for Rust.

## Importing the first Rust package

These entries are launch preparation, not access control. Once deployed and imported,
the guide is public, even if its source repository is private. Pushing this branch
does not import documentation into production or authorize a deployment.

Only `spatie/rust-crawler` is registered initially. Its `main` branch contains the
`v0.2` guide. Ensure the website's `GITHUB_ACCESS_TOKEN` (falling back to
`GITHUB_TOKEN`) can read that private repository, including its raw documentation
files. A fine-grained token needs repository contents read access. Verify this in
the target environment; successful access from an orb does not establish that the
production token has permission.

After deployment is approved, run
`php artisan docs:import --repo=spatie/rust-crawler` in the target environment.
Verify the Rust category, introduction, nested links and code blocks. The weekly
search crawl picks up the new pages; include reindexing in the launch if search
must be available immediately. Additional Rust packages should only be registered
when their repositories and guides are available to the importer.

The daily `app:import-all-docs` command dispatches release-aware import jobs;
those jobs require a matching `Repository` database record. The GitHub repository
sync imports public repositories only. For a private source without that record,
use the explicit `docs:import --repo=...` command instead of the daily job. The
existing signed GitHub webhook records changed repositories for `docs:import`.

At public launch, import GitHub repositories and mark the Rust package visible in
the existing repository administration to include it in the general catalogue.
For subsequent Rust ports, add another registry entry with category `Rust` and
their own version alias; no new routes, tables, or importer are needed.
