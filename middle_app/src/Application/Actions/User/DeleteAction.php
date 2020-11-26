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
        $userId = (int) $this->resolveArg('id');
        // get cookie token
        $client = new Client(['headers' => ['autorisation' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjQsImlhdCI6MTYwNjM5OTk2OCwiZXhwIjoxNjA2NDA3MTY4fQ.B_phhbxoDmsAKh134Yb73ehmkPbrTJlZ_g_KIYNKOMc']]);
    
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