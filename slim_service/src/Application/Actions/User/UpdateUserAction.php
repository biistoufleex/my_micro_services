<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\User;
use \Firebase\JWT\JWT;


class UpdateUserAction extends UserAction
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

        $userId = (int) $this->resolveArg('id');
        if ($userId != $token->userId)
            return $this->respondWithData(['error'=>'Id in url and token doesnt match'], 400);

        $user = $this->user->find($userId);
        foreach($data as $key => $value) {
            if (isset($user->$key) && $key != 'id')
                $user->$key = $value;
        }
        $user->save();
        return $this->respondWithData($user);
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