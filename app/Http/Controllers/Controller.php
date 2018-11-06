<?php

namespace App\Http\Controllers;

use App\AppService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    private $httpClient;


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $token = $_ENV['API_TOKEN'];
        $this->httpClient = new Client(['headers' => ['X-Auth-Token' => $token]]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function call(Request $request)
    {
        $client = new Client(['headers' => ['X-Auth-Token' => 'a7c8f168d2f14f02bd678f24fa05aff0']]); //GuzzleHttp\Client

        $result = $client->get('http://api.football-data.org' . $request->getRequestUri())
            ->getBody()->getContents();

        return \response()->json(
            json_decode($result),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getCompetionMatches(Request $request, $id)
    {
        $response = app(AppService::class)
            ->getCompetionMatches($id, $request->query->get('matchday'), $request->query->get('stage'));

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getCompetionStanding($id)
    {
        $response = app(AppService::class)->getCompetionStanding($id);

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getTodayMatches()
    {
        $response = app(AppService::class)->getTodayMatches();

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getCompetionScorers($id)
    {
        $response = app(AppService::class)->getCompetitionScorers($id);

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getCompetionMatche($id, $matcheId)
    {
        $response = app(AppService::class)->getCompetionMatche($id, $matcheId);

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function getNews(Request $request)
    {
        $response = app(AppService::class)->getNews($request->query->get('lang'));

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
