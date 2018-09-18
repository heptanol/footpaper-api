<?php

namespace App\Http\Controllers;

use function GuzzleHttp\default_user_agent;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function call(Request $request)
    {
        Cache::store('file')->set('foo', 'test');
        $value = Cache::store('file')->get('foo');
        var_dump($value);die;
        $client = new Client(['headers' => ['X-Auth-Token' => 'a7c8f168d2f14f02bd678f24fa05aff0']]); //GuzzleHttp\Client

        $result = $client->get('http://api.football-data.org/v2/' . $request->getRequestUri());


        return \response()->json(
            json_decode($result->getBody()->getContents()),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
