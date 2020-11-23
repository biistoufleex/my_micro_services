<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    protected function action(): Response
    {
        $allusers = $this->user->all();
        return $this->respondWithData($allusers);
    }
}
