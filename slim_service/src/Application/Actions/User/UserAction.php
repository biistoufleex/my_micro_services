<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\User;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    /**
    * @var User
    */
    protected $user;
    
    /**
    * @param LoggerInterface $logger
    * @param User  $user
    */
    public function __construct(LoggerInterface $logger, User $user)
    {
        parent::__construct($logger);
        $this->user = $user;
    }
}