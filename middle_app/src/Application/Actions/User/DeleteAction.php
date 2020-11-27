<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class DeleteAction extends RequestAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
       
        if (!isset($data['token'])) {
            return $this->respondWithData(['error' => 'token required'], 400);
        }
        $token = $data['token'];

        if (!isset($data['id'])) {
            return $this->respondWithData(['error' => 'id required'], 400);
        }
        $userId = $data['id'];

        $client = new Client(['headers' => ['autorisation' => $token]]);

        try {
            $result = $client->delete('http://localhost:8080/users/' . $userId . '/delete');

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

        return $this->respondWithData($response->data, 200);
    }
}