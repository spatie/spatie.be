<?php

namespace App\Support\Socialite;

use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class SignInWithAppleProvider extends AbstractProvider implements ProviderInterface
{
    protected $encodingType = PHP_QUERY_RFC3986;
    protected $scopeSeparator = ' ';
    protected $scopes = ['name', 'email'];

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://appleid.apple.com/auth/authorize', $state);
    }

    protected function getState()
    {
        return json_encode(Arr::except(session()->all(), ['_flash', '_previous']));
    }

    protected function getCodeFields($state = null)
    {
        return array_merge([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
            'response_type' => 'code',
            'response_mode' => 'form_post',
        ], $this->usesState() ? ['state' => $state] : [], $this->parameters);
    }

    protected function getTokenUrl()
    {
        return 'https://appleid.apple.com/auth/token';
    }

    public function getAccessToken($code)
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => [
                'Authorization' => 'Basic '.base64_encode("{$this->clientId}:{$this->clientSecret}"),
            ],
            'body' => $this->getTokenFields($code),
        ]);

        return json_decode($response->getBody()->getContents(), true)['access_token'];
    }

    protected function getUserByToken($token)
    {
        $claims = explode('.', $token)[1];

        return json_decode(base64_decode($claims), true);
    }

    public function user()
    {
        $response = $this->getAccessTokenResponse($this->getCode());

        $user = $this->mapUserToObject(
            $this->getUserByToken(Arr::get($response, 'id_token'))
        );

        return $user
            ->setToken(Arr::get($response, 'id_token'))
            ->setRefreshToken(Arr::get($response, 'refresh_token'))
            ->setExpiresIn(Arr::get($response, 'expires_in'));
    }

    protected function mapUserToObject(array $user)
    {
        $userDetails = request()->json('user');

        if (Arr::has($userDetails, 'name')) {
            $fullName = implode(' ', $user['name'] = $userDetails['name']);
        }

        return (new User())->setRaw($user)->map([
            'id' => $user['sub'],
            'name' => $fullName ?? null,
            'email' => $user['email'] ?? null,
        ]);
    }
}
