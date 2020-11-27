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
        if (!isset($data['content']) || $data['content'] == "") {
            return $this->respondWithData(['error' => 'Message required'], 400);
        }
        if (!isset($data['token']) || $data['token'] == "") {
            return $this->respondWithData(['error' => 'Token required'], 400);
        }

        $token = $data['token'];
        $client = new Client(['headers' => ['autorisation' => $token]]);

        // check si la discussion existe
        try {
            $result = $client->request('POST', 'http://localhost:8000/checkOrCreate', [
                'form_params' => [
                    'sender' => $data['sender_id'],
                    'receiver' => $data['receiver_id']
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

        // save le message
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