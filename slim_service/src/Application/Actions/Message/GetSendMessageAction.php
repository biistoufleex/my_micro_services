<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

class GetSendMessageAction extends MessageAction
{
    protected function action(): Response
    {
        if (!$this->request->hasHeader('autorisation'))
            return $this->respondWithData(['error'=>'Token required'], 400);
        $token = $this->request->getHeader('autorisation');
        
        try {
            $token = JWT::decode($token[0], "notSecureKey", array("HS256"));
        } catch (\Exception $e) { 
            return $this->respondWithData(['error'=>'Token expired'], 400);
        }

        $sender_id = (int) $this->resolveArg('id');

        if ($sender_id != $token->userId)
            return $this->respondWithData(['error'=>'Not allowed'], 400);

        $message = $this->message->where('sender_id', 'like', $sender_id)->get();

        return $this->respondWithData($message);
    }
}