<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FacebookConversionAPIService
{
    protected $pixelId;
    protected $accessToken;
    protected $graphApiVersion;
    protected $client;

    public function __construct()
    {
        $this->pixelId = config('facebook.pixel_id');
        $this->accessToken = config('facebook.access_token');
        $this->graphApiVersion = config('facebook.graph_api_version');
        $this->client = new Client();
    }

    public function sendEvent($eventName, $eventData)
    {
        $url = "https://graph.facebook.com/{$this->graphApiVersion}/{$this->pixelId}/events";

        $data = [
            'data' => [
                [
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'event_source_url' => $eventData['event_source_url'],
                    'user_data' => $eventData['user_data'],
                    'custom_data' => $eventData['custom_data'],
                ],
            ],
            'access_token' => $this->accessToken,
        ];

        try {
            $response = $this->client->post($url, [
                'json' => $data,
            ]);

            Log::info('Facebook Conversion API Response', [
                'message' => $response->getBody()->getContents(),
            ]);
            return $response->getStatusCode();
        } catch (RequestException $e) {
            Log::error('Facebook Conversion API Request Exception', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body',
            ]);
            throw $e;
        }
    }
}
