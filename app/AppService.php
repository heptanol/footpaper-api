<?php

namespace App;


class AppService
{

    private $competitionMatches = 'competitions/{id}/matches';
    private $competitionStanding = 'competitions/{id}/standings';
    private $matches = 'matches';


    /**
     * @param $id
     * @param $matchday
     * @param $stage
     * @return string
     */
    public function getCompetionMatches($id, $matchday, $stage = null)
    {
        $uri = str_replace('{id}', $id, $this->competitionMatches);

        $result = app(HttpClient::class)->getRessources($uri);

        if (isset($stage)) {
            $result = app(Mapping::class)->filterByStage(json_decode($result), $stage);

            return json_encode($result);
        }

        $result = app(Mapping::class)->filterByMatchDay(json_decode($result), $matchday);

        return json_encode($result);
    }

    /**
     * @return string
     */
    public function getCompetionStanding($id)
    {
        $uri = str_replace('{id}', $id, $this->competitionStanding);

        return app(HttpClient::class)->getRessources($uri);
    }

    public function getTodayMatches()
    {
        $now = new \DateTime();
        $query = array(
            'dateFrom' => $now->format('Y-m-d'),
            'dateTo' => $now->format('Y-m-d')
        );
        $uri = $this->matches .'?'. http_build_query($query);

        $result = app(HttpClient::class)->getRessources($uri);

        $result = app(Mapping::class)->filterTodayMatchs(json_decode($result)->matches);

        return json_encode($result);
    }
}