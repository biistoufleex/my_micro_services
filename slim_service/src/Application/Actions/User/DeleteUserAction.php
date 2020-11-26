<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

class DeleteUserAction extends UserAction
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

        $userId = (int) $this->resolveArg('id');
        if ($userId != $token->userId)
            return $this->respondWithData(['error'=>'Not your account'], 400);

        $userId = (int) $this->resolveArg('id');
        $user = $this->user->destroy($userId);
        return $this->respondWithData($user);
    }
} 