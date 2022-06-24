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

    public function Add(User $user) : bool
    {
        $username = $message->GetUsername();
        $password = $message->GetPassword();

        $query = $this->connection->prepare("INSERT INTO users(username, password) VALUES (:username, :password))";
        return $query->execute(['username' => $username, 'password' => $password]);
    }
	
    public function Delete(int $id) : bool
    {
	    $query = $this->connection->prepare('DELETE FROM users WHERE id = :id');
        return $query->execute();
    }

    public function GetAll() : array
    {
        $query = $this->connection->prepare('SELECT username, password FROM users');
	
	    $query->execute();

        return $query->fetchAll();
    }
	
    public function GetById(int $id)
    {
	    $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
	    
        $query->execute(['id' => $id]);
        $data = $query->fetch();
	
        return new Message($data['username'], $data['password']);
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
