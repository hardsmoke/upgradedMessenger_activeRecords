<?php

namespace Messenger\Model\Entity;

class Message
{
    private string $username;
    private string $message;

    public function __construct(string $username, string $message)
    {
        $this->username = $username;
        $this->message = $message;
    }

    public function GetUsername() : string
    {
        return $this->username;
    }

    public function GetMessage() : string
    {
        return $this->message;
    }
}