<?php

namespace mdhedayet\appsumolicensing;

use GuzzleHttp\Client;

class AppSumo
{
    protected $client;
    protected $config;

    public function __construct()
    {
        $this->config = config('appsumo');
        $this->client = new Client();
    }

    /**
     * Example: Exchange code for access token.
     */
    public function getAccessToken($code)
    {
        $url = 'https://appsumo.com/openid/token/';
        $data = [
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'code'          => $code,
            'redirect_uri'  => $this->config['redirect_url'],
            'grant_type'    => 'authorization_code',
        ];

        $response = $this->client->post($url, [
            'json' => $data,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Example: Fetch user's license key using access token.
     */
    public function getLicense($accessToken)
    {
        $url = 'https://appsumo.com/openid/license_key/?access_token=' . $accessToken;
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true);
    }
}
