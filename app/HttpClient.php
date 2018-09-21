<?php

namespace App;


use GuzzleHttp\Client;

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


    public function getRessources(string $uri)
    {

        if (app('redis')->exists($uri)) {
            return app('redis')->get($uri);
        }
        $result = $this->guzzleClient->get($this->apiUrl . $uri)
            ->getBody()->getContents();
        app('redis')->set($uri, $result);

        return $result;
    }
}