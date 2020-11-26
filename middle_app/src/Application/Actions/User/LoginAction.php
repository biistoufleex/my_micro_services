<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class LoginAction extends RequestAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $client = new Client();
        try {
            $result = $client->request('POST', 'http://localhost:8080/users/login', [
                'form_params' => [
                    'username' => $data['username'],
                    'password' => $data['password'],
                ]
            ]);

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                return $response;
            } else {
                $response = $e->getHandlerContext();
                return $response;
            }
        }

        $response = json_decode($result->getBody()->read(10241));
        $res = $this->response->withHeader('Content-type', 'application/json');
        $token = $response->data->token;   
        file_put_contents('token', print_r($response, true));
        // metre en cookie

        return $this->respondWithData($response, 200)->withHeader('token', $token);
    }
}