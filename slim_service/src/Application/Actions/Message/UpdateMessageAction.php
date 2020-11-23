<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Animal\Message;

class UpdateMessageAction extends MessageAction
{
    protected function action(): Response
    {
        $data = $this->parseBody();
        $messageId = (int) $this->resolveArg('id');
        $message = $this->message->find($messageId);
        foreach($data as $key => $value) {
            if (isset($message->$key))
            $message->$key = $value;
        }
        $message->save();
        return $this->respondWithData($message);
    }
    
    protected function parseBody() {
        // parsing from key=value&key2=value2 to [key => value, key2 => value2]
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