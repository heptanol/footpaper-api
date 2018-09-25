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
        $this->guzzleClient = new Client(['headers' => ['X-Auth-Token' => 'a7c8f168d2f14f02bd678f24fa05aff0']]);
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
}