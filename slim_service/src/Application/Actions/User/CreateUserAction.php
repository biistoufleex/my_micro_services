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
        $username = (string) $data['username'];
        $password = (string) $data['password'];

        $exists = $this->user->where('username', 'like', $username)->exists();


        if (!$exists) {

            $user = new User;
            $user->username = $username;
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $user->password = $hash;
            $user->save();
            return $this->respondWithData('ok');
        } 
        
        return $this->respondWithData(['error'=>'Username taken'], 400);
    }
}