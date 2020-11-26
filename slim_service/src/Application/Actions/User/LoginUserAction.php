<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;
use \Tuupola\Base62;
use \Datetime;

class LoginUserAction extends UserAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $username = (string) $data['username'];
        $password = (string) $data['password'];

        $user = $this->user->where('username', 'like', $username)->first();

        if (!isset($user))
            return $this->respondWithData(['error'=>'incorect username'], 400);
        if (!password_verify($password, $user->password))
            return $this->respondWithData(['error'=>'wrong password'], 400);

        $now = new DateTime();
        $future = new DateTime("now +2 hours");
        // $future = new DateTime("now +1 sec");
    
        $payload = [
            "userId" => $user->id,
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
        ];
    
        $secret = "notSecureKey";
        $token = JWT::encode($payload, $secret, "HS256");
        
        $result['username'] = $user->username;
        $result["token"] = $token;
        $result["expires"] = $future->getTimeStamp();

        return $this->respondWithData($result, 200)->withHeader('token', $token);
    }
}
