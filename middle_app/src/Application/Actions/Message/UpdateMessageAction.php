<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class UpdateMessageAction extends RequestAction
{
    protected function action(): Response
    {
        $messageId = (int) $this->resolveArg('id');
        $data = $this->request->getParsedBody();
        if (!isset($data['content']) || $data['content'] == "") {
            return $this->respondWithData(['error' => 'Message required'], 400);
        }
        if (!isset($data['token']) || $data['token'] == "") {
            return $this->respondWithData(['error' => 'Token required'], 400);
        }

        $token = $data['token'];
        $client = new Client(['headers' => ['autorisation' => $token]]);
    
        try {
            $result = $client->request('PUT', 'http://localhost:8080/messages/' . $messageId . '/update', [
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