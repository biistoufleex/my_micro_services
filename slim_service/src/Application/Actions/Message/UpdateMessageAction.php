<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Animal\Message;
use \Firebase\JWT\JWT;

class UpdateMessageAction extends MessageAction
{
    protected function action(): Response
    {
        $data = $this->parseBody();

        if (!$this->request->hasHeader('autorisation'))
            return $this->respondWithData(['error'=>'Token required'], 400);
        $token = $this->request->getHeader('autorisation');
        
        try {
            $token = JWT::decode($token[0], "notSecureKey", array("HS256"));
        } catch (\Exception $e) { 
            return $this->respondWithData(['error'=>'Token expired'], 400);
        }

        $messageId = (int) $this->resolveArg('id');
        $message = $this->message->find($messageId);
        if (!isset($message))
            return $this->respondWithData(['error'=>'Message not found'], 400);

        if ($message->sender_id != $token->userId) 
            return $this->respondWithData(['error'=>'Not allowed'], 400);

        foreach($data as $key => $value) {
            if (isset($message->$key) && $key != 'id')
                $message->$key = $value;
        }
        $message->save();
        return $this->respondWithData($message);
    }
    
    protected function parseBody() {
        $data;
        $raw = $this->request->getBody()->getContents();
        if (empty($raw))
            return $this->request->getParsedBody();
        $cutted = explode("&", $raw);
        foreach ($cutted as $param) {
            list($key, $value) = explode("=", $param);
            $data[$key] = $value;
        }
        return $data;
    }
}