<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Animal\User;

class UpdateUserAction extends UserAction
{
    protected function action(): Response
    {
        $data = $this->parseBody();
        $userId = (int) $this->resolveArg('id');
        $user = $this->user->find($userId);
        foreach($data as $key => $value) {
            if (isset($user->$key))
            $user->$key = $value;
        }
        $user->save();
        return $this->respondWithData($user);
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