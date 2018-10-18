<?php

namespace App;


class AppService
{

    private $competitionMatches = 'competitions/{id}/matches';
    private $competitionStanding = 'competitions/{id}/standings';
    private $competitionScorers = 'competitions/{id}/scorers';
    private $matches = 'matches';

    private $feeds = array(
        "http://www.goal.com/fr/feeds/news?fmt=rss&ICID=HP",
        "https://www.lequipe.fr/rss/actu_rss_Football.xml",
        "https://www.eurosport.fr/football/rss.xml",
    );


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
     * @param $id
     * @param $matchId
     * @return string
     */
    public function getCompetionMatche($id, $matchId)
    {
        $uri = str_replace('{id}', $id, $this->competitionMatches);

        $result = app(HttpClient::class)->getRessources($uri);

        $result = app(Mapping::class)->getOneMatch(json_decode($result), $matchId);

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

        $result = app(HttpClient::class)->getRessources($uri, 60);

        $result = app(Mapping::class)->filterTodayMatchs(json_decode($result)->matches);

        return json_encode($result);
    }

    public function getCompetitionScorers($id)
    {
        $uri = str_replace('{id}', $id, $this->competitionScorers);

        return app(HttpClient::class)->getRessources($uri, 3600);
    }

    /**
     * @return string
     */
    public function getNews()
    {
        $entries = array();
        foreach($this->feeds as $feed) {
            $xml = simplexml_load_file($feed);
            $entries = array_merge($entries, $xml->xpath("//item"));
        }

        return json_encode($entries);
    }
}