<?php

declare(strict_types=1);

namespace App\Application\Actions\Request;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class RegisterAction extends RequestAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $client = new Client();

        try {
            $result = $client->request('POST', 'http://localhost:8080/users/create', [
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
        return $this->respondWithData($response, 200);

    }
}