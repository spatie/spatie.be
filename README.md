# The source code of spatie.be

[![Tests](https://github.com/spatie/spatie.be/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/spatie.be/actions/workflows/run-tests.yml)
[![Tuple](https://img.shields.io/badge/Pairing%20with-Tuple-5A67D8)](https://tuple.app) 

This repo contains the source code of [our company website](https://spatie.be). [This blog post series at freek.dev](https://freek.dev/1789-selling-digital-products-using-laravel-part-1-intro-a-tour-of-spatiebe) contains a lot of info on how this code works.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/spatiebe.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/spatie.be)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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
