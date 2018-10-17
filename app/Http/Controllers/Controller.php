<?php

namespace App\Http\Controllers;

use App\AppService;
use App\HttpClient;
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
    private $httpClient;


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->httpClient = new Client(['headers' => ['X-Auth-Token' => 'a7c8f168d2f14f02bd678f24fa05aff0']]);
    }


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

    public function getNews()
    {
        $feeds = array(
            "http://www.goal.com/fr/feeds/news?fmt=rss&ICID=HP",
            "https://www.lequipe.fr/rss/actu_rss_Football.xml",
            "https://www.eurosport.fr/football/rss.xml",
        );

        //Read each feed's items
        $entries = array();
        foreach($feeds as $feed) {
            $xml = simplexml_load_file($feed);
            $entries = array_merge($entries, $xml->xpath("//item"));
        }
        $response = json_encode($entries);

        return \response()->json(
            json_decode($response),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
