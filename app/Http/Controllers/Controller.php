<?php

namespace App\Http\Controllers;

use App\AppService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    /**
     * Controller constructor.
     */
    public function __construct()
    {}


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
