<?php

namespace Messenger\Model\Entity;

use JetBrains\PhpStorm\ArrayShape;
use ReturnTypeWillChange;

class User implements \JsonSerializable
{
    private string $username;
    private string $password;

    public function __construct(?string $username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function GetUsername() : string
    {
        return $this->username;
    }

    public function GetPassword() : string
    {
        return $this->password;
    }

    public function Hash(string $string) : string
    {
        return password_hash($string);
    }

    public function GetHashedPassword() : string
    {
        return Hash($this->password);
    }

    #[ReturnTypeWillChange]
    #[ArrayShape(['username' => "null|string", 'password' => "string"])]
    public function jsonSerialize(): array
    {
        return
        [
            'username' => $this->username,
            'password' => $this->password
        ];
    }
}