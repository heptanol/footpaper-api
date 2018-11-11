<?php
/**
 * Created by PhpStorm.
 * User: adminuser
 * Date: 08/11/18
 * Time: 17:53
 */

namespace App\Console\Commands;


use App\HttpClient;
use Illuminate\Console\Command;

class GetMatchesCommand extends Command
{
    private $competitionsId = [2015, 2014, 2021, 2019, 2002, 2017, 2003, 2001];
    private $apiUrl = 'competitions/{id}/matches';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $executionStartTime = microtime(true);
        $this->line("[Start] getting All matches");

        foreach ($this->competitionsId as $compId) {
            $this->line("[Start] getting matches for: ". $compId);
            $uri = str_replace('{id}', $compId, $this->apiUrl);
            try {
                app(HttpClient::class)->getRessources($uri);
                $this->info("[Success] on getting matches for: ". $compId);

            } catch (\Error $error) {
                $this->error("[Error] on getting matches for: ". $compId);
            }
        }
        $executionEndTime = microtime(true);
        $time = $executionEndTime-$executionStartTime;
        $this->comment("[Time] This script took ". $time ." to execute.");
    }
}