# Blog

Blog posts are managed under **Content → Blog Posts** in Filament. Save a draft before uploading images. Saving a published post takes effect immediately; future publication dates stay hidden until that time. Publication dates use UTC in the editor and public pages. Published slugs are locked. Preview requires an administrator and sends `noindex, nofollow` and `private, no-store`.

Uploads use the existing `medialibrary` disk, scoped to `cloud-public` on Laravel Cloud. Draft attachments are also public: do not upload confidential material. Replaced or cleared header/social images move to post uploads without deleting their files. New originals use unique filenames and immutable one-year cache headers. JPEG/PNG responsive images run on the existing `long-running` queue; video originals are retained. Browser uploads allow 12 MiB. Livewire temporary uploads use the existing private disk.

Blog HTML is not full-page cached because the layout includes session-dependent content. The homepage, author pages, feed and blog query the local database. No separate Cloudflare zone is required for Cloud's existing image CDN.
