<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\User;

class CreateUserAction extends UserAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $user = new User;
        $user->username = $data["username"];
        $hash = password_hash($data["password"], PASSWORD_DEFAULT);
        $user->password = $hash;
        $user->save();
        return $this->respondWithData($user);
    }
}