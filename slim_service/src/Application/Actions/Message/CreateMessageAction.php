<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Message\Message;

class CreateMessageAction extends MessageAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $message = new Message;
        $message->receiver_id = $data["receiver_id"];
        $message->sender_id = $data["sender_id"];
        $message->content = $data["content"];
        $message->save();
        return $this->respondWithData($message);
    }
}