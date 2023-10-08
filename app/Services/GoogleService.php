<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Oauth2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class GoogleService
{
    public $status = false;

    public Client $client;

    private Calendar $calendar;

    private $calendarId;

    private $accessToken;

    private $refreshToken;

    private $scopes = [
        Calendar::CALENDAR
    ];

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName(config('app.name'));
        $this->client->setScopes($this->scopes);
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
        $this->client->setApprovalPrompt('force');
    }

    public function profile()
    {
        $oauth2 = new Oauth2($this->client);

        dd($oauth2->userinfo);
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->client->setAccessToken($accessToken);
    }

    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->refreshToken);
        }
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function fetchAccessTokenWithAuthCode($code)
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);

        $this->setAccessToken($accessToken['access_token']);

        $this->setRefreshToken($this->client->getRefreshToken());

        return $accessToken;
    }

    public function userInfo()
    {
        $oauth2 = new Oauth2($this->client);

        return $oauth2->userinfo->get();
    }
}
