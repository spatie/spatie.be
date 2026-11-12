# Blog content migration

Blog posts are managed under **Content → Blog Posts** in Filament. Save a draft before uploading images. Saving a published post takes effect immediately; future publication dates stay hidden until that time. Publication dates use UTC in the editor and public pages, preserving the previous CMS display. Published slugs are locked. Preview requires an administrator and sends `noindex, nofollow` and `private, no-store`.

Uploads use the existing `medialibrary` disk, scoped to `cloud-public` on Laravel Cloud. Draft attachments are also public: do not upload confidential material. Replaced or cleared header/social images move to post uploads without deleting their files. New originals use unique filenames and immutable one-year cache headers. JPEG/PNG responsive images run on the existing `long-running` queue; video originals are retained. Browser uploads allow 12 MiB, migration originals 30 MiB. Livewire temporary uploads use the existing private disk.

Blog HTML is not full-page cached because the layout includes session-dependent content. The homepage, author pages, feed and blog query the local database. No separate Cloudflare zone is required for Cloud's existing image CDN.

## Import

Keep the private version 1 snapshot outside the public directory and out of Git. It contains `manifest.json`, `SHA256SUMS`, raw Markdown and original media. Verify the archive hash before extracting it. The manifest must contain only the `posts` collection's `spatie` product, with resolved authors/assets and no working copies or revisions. Preserve source timezone, dates, IDs and ordered author lists.

```sh
php artisan blog:import /private/path/to/snapshot --dry-run
php artisan blog:import /private/path/to/snapshot
php artisan blog:import /private/path/to/snapshot --dry-run
```

The command validates every file and reference before writing. It prints JSON counts on success. Failures can contain source identifiers: capture them privately rather than exposing them in shared command logs. It locks concurrent imports, resumes incomplete posts, and skips completed or deleted posts without overwriting subsequent edits. A changed source record after import requires manual reconciliation.

Cloud allows 512 MB of ephemeral disk per 1 GB RAM; host-level `df` or `disk_free_space()` does not measure that allowance. Do not download and extract the full snapshot on a 1 GB instance. Partition it into independently verified snapshots containing whole posts and their referenced originals, then process one small batch at a time with enough space for the archive, extracted files and application overhead.

Laravel's S3 driver defaults `stream_reads` to false: even `readStream()` can buffer a complete download into a local temporary file. For migration transfers, use an explicitly streamed S3 response (`@http.stream = true`) and incremental hashing, without changing the application's global disk behavior. Verify each batch hash before extraction.

On Cloud, download, verify, extract and invoke the command within the same remote execution; different commands may run on different instances. Transfer archives through `cloud-private`, never public objects. Remove each temporary archive and extraction directory in a `finally` block before starting the next batch, including on failure. Remove private transfer objects after verification. Retain the original private export for recovery.

## Cutover and rollback

1. Freeze source editing, recheck the source snapshot, and record an available destination database backup. Keep all source posts and assets intact.
2. Deploy the additive migration and application change, then dry-run and import the verified snapshot. Only blog availability may be interrupted during import; do not enable site-wide maintenance mode.
3. Verify all source slugs, publication dates, authors, tags and original-media hashes. Confirm published URLs return 200 and drafts return 404. Check the homepage, blog pagination, author pages, feed and authenticated previews.
4. Exercise an actual browser upload against production's private temporary storage, save a disposable draft, check its public image URL and responsive variants, then remove only that test data. Confirm scheduled visibility and unpublishing without cached content.
5. For rollback, redeploy the pre-migration application revision, which still reads the intact source CMS. Keep the new table and imported media; do not restore the whole database and overwrite unrelated orders/users. Reconcile any destination-only edits before attempting another cutover.

Source deletion is a separate operation and is not part of this migration.
