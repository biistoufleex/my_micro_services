<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Slim\Psr7\Response;

class TokenMiddleware extends Middleware {

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface {            
        $loggedInTest = false;
        if ($loggedInTest) {
            $response = $handler->handle($request);
            echo "User authorized.";
            return $response;
        } else {
            $response = new Response();
            // echo "User NOT authorized.";
            return $response->withHeader('Location', '/')->withStatus(404);
        }
    }
}