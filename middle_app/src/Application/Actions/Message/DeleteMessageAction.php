<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class DeleteMessageAction extends RequestAction
{
    protected function action(): Response
    {
        $data = $this->parseBody();
        $userId = (int) $this->resolveArg('id');
        $client = new Client(['headers' => ['autorisation' => $data['token']]]);
    
        try {
            $result = $client->delete('http://localhost:8080/messages/' . $userId . '/delete');

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