<?php

namespace App\Http\Controllers;

use App\Mapping;
use App\Providers\AppServiceProvider;
use App\User;
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
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function call(Request $request)
    {
        $client = new Client(['headers' => ['X-Auth-Token' => 'a7c8f168d2f14f02bd678f24fa05aff0']]); //GuzzleHttp\Client

        if (app('redis')->exists($request->getRequestUri())) {
            $result = app('redis')->get($request->getRequestUri());
        } else {
            $result = $client->get('http://api.football-data.org/v2/' . $request->getRequestUri())
                ->getBody()->getContents();
            app('redis')->set($request->getRequestUri(), $result);
            app('redis')->expire($request->getRequestUri(), 60);
        }

        return \response()->json(
            json_decode($result),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getCompetionMatches($id)
    {
        var_dump(app(Mapping::class));die;
    }

    public function getCompetionStanding($id, array $query)
    {
    }

    public function getMatches()
    {
    }
}
