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

    private $accessToken;

    private $refreshToken;

    private $scopes = [
        Calendar::CALENDAR
    ];

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName(config('app.name'));
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setScopes([
            Calendar::CALENDAR,
        ]);
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
            $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
        }
    }

    public function getEvents()
    {
        $service = new Calendar($this->client);

        $calendarId = 'primary';

        $optParams = [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];

        $results = $service->events->listEvents($calendarId, $optParams);

        $events = $results->getItems();

        return $events;
    }
}
