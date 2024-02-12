<?php

declare(strict_types=1);

use App\Application\Actions\Exec\StartExecAction;
use App\Application\Actions\Exec\StopExecAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) use ($app) {
        $c = $app->getContainer();
        return $c->get('view')->render($response, 'index.html', [
            'name' => 'hello',
        ]);
    });

    $app->group('/exec', function (Group $group) {
        $group->post('/start', StartExecAction::class);
        $group->post('/stop', StopExecAction::class);
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
