<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class CreateAction extends RequestAction
{
    protected function action(): Response
    {
        // receiver_id sender_id content
        $data = $this->request->getParsedBody();

        // recup token dans cookie
        $client = new Client(['headers' => ['autorisation' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjEsImlhdCI6MTYwNjM5ODQ2NCwiZXhwIjoxNjA2NDA1NjY0fQ.XihR0TxMpg0xlT1hXWiSF0d0AytSLxju8atHnRMheuM']]);

        try {
            $result = $client->request('POST', 'http://localhost:8080/messages/create', [
                'form_params' => [
                    'sender_id' => $data['sender_id'],
                    'receiver_id' => $data['receiver_id'],
                    'content' => $data['content']
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