<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return 'hello world';
});

$router->get('/competitions/{id}/matches', 'Controller@getCompetionMatches');
$router->get('/competitions/{id}/standings', 'Controller@getCompetionStanding');
$router->get('/matches', 'Controller@getMatches');
$router->get('/{url:.+}', 'Controller@call');

