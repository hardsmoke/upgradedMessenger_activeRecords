<?php

namespace Messenger\Repository;

use Messenger\Model\Message;

interface IMessageRepository
{
    public function Save(Message $message);
    public function GetAll() : array;
}