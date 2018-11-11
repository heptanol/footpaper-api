<?php

namespace App;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class HttpClient
{
    private $guzzleClient;

    private $apiUrl = 'http://api.football-data.org/v2/';

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $token = $_ENV['API_TOKEN'];
        $this->guzzleClient = new Client(['headers' => ['X-Auth-Token' => $token]]);
    }


    public function getRessources(string $uri, $ttl = 300)
    {

        if (app('redis')->exists('temp_'.$uri)) {
            Log::info('cache');
            return app('redis')->get('temp_'.$uri);
        }

        try {
            $result = $this->guzzleClient->get($this->apiUrl . $uri);
        } catch (\Error $error) {}

        if (isset($result)) {
            $result = $result->getBody()->getContents();
            app('redis')->set($uri, $result);
            app('redis')->set('temp_'.$uri, $result);
            app('redis')->expire('temp_'.$uri, $ttl);
            Log::info('API');
        } elseif (app('redis')->exists($uri)) {
            $result = app('redis')->get($uri);
            Log::info('cache_permanent');
        } else {
            $result = null;
        }

        return $result;
    }

    public function getResourceFromApi(string $uri, $ttl = 295)
    {
        try {
            $result = $this->guzzleClient->get($this->apiUrl . $uri);
        } catch (\Error $error) {}

        if (isset($result)) {
            $result = $result->getBody()->getContents();
            app('redis')->set($uri, $result);
            app('redis')->set('temp_'.$uri, $result);
            app('redis')->expire('temp_'.$uri, $ttl);
        }

    }
}