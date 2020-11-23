<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class GetMessageAction extends MessageAction
{
    protected function action(): Response
    {
        $messageId = (int) $this->resolveArg('id');
        $message = $this->message->find($messageId);
        return $this->respondWithData($message);
    }
}