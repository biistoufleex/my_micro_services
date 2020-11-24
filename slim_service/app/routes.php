<?php
declare(strict_types=1);

// import de toute les fonctions

// User
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\GetUserAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\LoginUserAction;

// Message
use App\Application\Actions\Message\ListMessagesAction;
use App\Application\Actions\Message\GetMessageAction;
use App\Application\Actions\Message\CreateMessageAction;
use App\Application\Actions\Message\UpdateMessageAction;
use App\Application\Actions\Message\DeleteMessageAction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\App;

return function (App $app) {

    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', GetUserAction::class);
        $group->post('/create', CreateUserAction::class);
        $group->put('/{id}/update', UpdateUserAction::class);
        $group->delete('/{id}/delete', DeleteUserAction::class); // si id = id 
        $group->post('/login', LoginUserAction::class);
    });

    $app->group('/messages', function (Group $group) {
        $group->get('', ListMessagesAction::class);
        $group->get('/{id}', GetMessageAction::class);
        $group->post('/create', CreateMessageAction::class);
        $group->put('/{id}/update', UpdateMessageAction::class);
        $group->delete('/{id}/delete', DeleteMessageAction::class);
    });
};
