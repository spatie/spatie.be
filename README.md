# The source code of spatie.be

[![Ttests](https://github.com/spatie/spatie.be/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/spatie.be/actions/workflows/run-tests.yml)

This repo contains the source code of [our company website](https://spatie.be). [This blog post series at freek.dev](https://freek.dev/1789-selling-digital-products-using-laravel-part-1-intro-a-tour-of-spatiebe) contains a lot of info on how this code works.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/spatiebe.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/spatie.be)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Credits

This website was principally designed by [Willem Van Bockstal](https://github.com/orgs/spatie/people/willemvb). [Everyone at Spatie](https://github.com/orgs/spatie/people) has made cool contributions during development.

## License

-   The web application falls under the [MIT License](https://choosealicense.com/licenses/mit/)
-   The content and design are under [exclusive copyright](https://choosealicense.com/no-license/)

If you'd like to reuse or repost something, feel free to hit us up at info@spatie.be. Please remember that the design is not meant to be forked!

## License

This project and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Apple sign-in

Every 6 months, the token for Sign-in with Apple expires, this can be renewed using the "Spatie apple login - private key" in our team's 1Password vault and the following ruby script:

```ruby
require 'jwt'

key_file = 'key.txt'
team_id = '' # Found in the top right when signed in on the Apple developer site
client_id = 'be.spatie.website'
key_id = '' # The key ID, found here https://developer.apple.com/account/resources/authkeys/list

ecdsa_key = OpenSSL::PKey::EC.new IO.read key_file

headers = {
'kid' => key_id
}

claims = {
    'iss' => team_id,
    'iat' => Time.now.to_i,
    'exp' => Time.now.to_i + 86400*180,
    'aud' => 'https://appleid.apple.com',
    'sub' => client_id,
}

token = JWT.encode claims, ecdsa_key, 'ES256', headers

puts token
```

Then execute it using

```shell
ruby client_secret.rb
```

Which gives you a new token that is valid for 6 months.
