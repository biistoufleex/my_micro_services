<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class GetReceiveMessageAction extends RequestAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');

        $client = new Client(['headers' => ['autorisation' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjEsImlhdCI6MTYwNjQwMTM3NiwiZXhwIjoxNjA2NDA4NTc2fQ.BISu3iUdKGiwJQWGVfjlL1TGWNKLtpnXyNDCSuBaZYU']]);
    
        try {
            $result = $client->get('http://localhost:8080/messages/receive/' . $userId);

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