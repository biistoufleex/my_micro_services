<?php
declare(strict_types=1);

namespace App\Domain\Message;

interface MessageRepository
{
    /**
     * @return Message[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Message
     * @throws MessageNotFoundException
     */
    public function findMessageOfId(int $id): Message;
}
