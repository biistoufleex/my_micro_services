<?php
declare(strict_types=1);

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

use App\Application\Actions\User\RegisterAction;
use App\Application\Actions\User\LoginAction;
use App\Application\Actions\User\UpdateAction;
use App\Application\Actions\User\DeleteAction;
use App\Application\Actions\User\GetAllAction;
use App\Application\Actions\User\GetOneAction;

use App\Application\Actions\Message\CreateAction;
use App\Application\Actions\Message\AllMessageAction;
use App\Application\Actions\Message\DeleteMessageAction;
use App\Application\Actions\Message\GetSendMessageAction;
use App\Application\Actions\Message\GetReceiveMessageAction;
use App\Application\Actions\Message\UpdateMessageAction;
use App\Application\Actions\Message\AllDiscussionAction;




return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('/all', GetAllAction::class);
        $group->post('/register', RegisterAction::class);
        $group->post('/login', LoginAction::class);
        $group->post('/update', UpdateAction::class);
        $group->post('/delete', DeleteAction::class);
        $group->get('/{id}', GetOneAction::class);
    });

    $app->group('/message', function (Group $group) {
        $group->get('', AllMessageAction::class);
        $group->get('/{id}/discussion', AllDiscussionAction::class);
        $group->post('/create', CreateAction::class);
        $group->post('/{id}/delete', DeleteMessageAction::class);
        $group->get('/send/{id}', GetSendMessageAction::class);
        $group->get('/receive/{id}', GetReceiveMessageAction::class);
        $group->post('/update/{id}', UpdateMessageAction::class);
      
    });

};
