<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class ListMessagesAction extends MessageAction
{
    protected function action(): Response
    {
        $allmessages = $this->message->all();
        return $this->respondWithData($allmessages);
    }
}
