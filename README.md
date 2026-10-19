# The source code of spatie.be

[![Tests](https://github.com/spatie/spatie.be/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/spatie.be/actions/workflows/run-tests.yml)
[![Tuple](https://img.shields.io/badge/Pairing%20with-Tuple-5A67D8)](https://tuple.app) 

This repo contains the source code of [our company website](https://spatie.be). [This blog post series at freek.dev](https://freek.dev/1789-selling-digital-products-using-laravel-part-1-intro-a-tour-of-spatiebe) contains a lot of info on how this code works.

## Development in Amp orbs

Amp runs `.agents/setup` when preparing a project snapshot. It installs PHP 8.5
(matching CI), Composer 2, Node.js 22.22.0, the npm version from `package.json`,
and dependencies from both lockfiles. It also builds Vite assets and migrates a
local MySQL 8.4 database. Exact snapshot matches reuse this work; warm setup runs
reuse installed system packages and package-manager download caches.

Setup creates `.env` only when it is missing and preserves an existing app key.
The local databases are `spatie` and `spatie_tests`, with user `orb`, no password,
and host `127.0.0.1`. The user can also create Pest's parallel test databases.
MySQL and Redis run under systemd; `.agents/resume` ensures they are running
without reinstalling dependencies. MySQL is required rather than MariaDB because
the search timeout tests exercise MySQL's `MAX_EXECUTION_TIME` hint.

Run `composer test` for tests, or `amp orb services ensure` to start the website
and get its authenticated preview URL. The preview uses built assets; run
`npm run build` after frontend changes. Databases start without demo content.
Run `php artisan db:seed` when you need the repository's demo data; the full
seeder is not idempotent, so setup does not run it automatically. External
integrations such as Paddle, GitHub OAuth and MaxMind still need their own
credentials; do not commit those or copy production data into a snapshot.

Setup runs Composer's autoload/discovery hooks explicitly, skipping the existing
post-install hook that attempts to execute a missing local `composer` PHP file.
It does not update either lockfile. Both lifecycle scripts are safe to rerun.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/spatiebe.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/spatie.be)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Deployment

The site runs on [Laravel Cloud](https://cloud.laravel.com) and deploys automatically when pushing to `main`.

## Credits

This website was principally designed by [Willem Van Bockstal](https://github.com/willemvb). [Everyone at Spatie](https://github.com/orgs/spatie/people) has made cool contributions during development.

## License

-   The web application falls under the [MIT License](https://choosealicense.com/licenses/mit/)
-   The content and design are under [exclusive copyright](https://choosealicense.com/no-license/)

If you'd like to reuse or repost something, feel free to hit us up at info@spatie.be. Please remember that the design is not meant to be forked!

## License

This project and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## GeoIP lookup

We use Maxmind's geo IP dataset to provide PPP based on IP location. This is built using the excellent [laravel-geoip](https://lyften.com/projects/laravel-geoip) package.

To set it this up the first time you'll need a Maxmind license key (free for personal use) in the `MAXMIND_LICENSE_KEY` environment variable. Next, run the `php artisan geoip:update` command to pull in the geo IP dataset.

In production, the `geoip:update` command is scheduled to run weekly.
