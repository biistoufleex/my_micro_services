<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class UpdateAction extends RequestAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        if (!isset($data['token'])) {
            return $this->respondWithData(['error' => 'token required'], 400);
        }
        $token = $data['token'];
      
        $client = new Client(['headers' => ['autorisation' => $token]]);
    
        try {
            $result = $client->request('PUT', 'http://localhost:8080/users/' . $data['id'] . '/update', [
                'form_params' => $data
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

        return $this->respondWithData($response->data, 200);
    }
}