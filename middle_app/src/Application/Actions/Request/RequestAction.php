<?php

declare(strict_types=1);

namespace App\Application\Actions\Request;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class RequestAction extends Action
{

    /**
    * @param LoggerInterface $logger
    */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }
}