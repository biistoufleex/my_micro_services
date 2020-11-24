<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Message\Message;
use \Firebase\JWT\JWT;

class CreateMessageAction extends MessageAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();

        if (!$this->request->hasHeader('autorisation'))
            return $this->respondWithData(['error'=>'Token required'], 400);
        $token = $this->request->getHeader('autorisation');
        
        try {
            $token = JWT::decode($token[0], "notSecureKey", array("HS256"));
        } catch (\Exception $e) { 
            return $this->respondWithData(['error'=>'Token expired'], 400);
        }

        $userId = $data["sender_id"];
        if ($userId != $token->userId)
            return $this->respondWithData(['error'=>'sender id incorect'], 400);

        $message = new Message;
        $message->receiver_id = $data["receiver_id"];
        $message->sender_id = $data["sender_id"];
        $message->content = $data["content"];
        $message->save();
        return $this->respondWithData($message);
    }
}