<?php

namespace Messenger\Model\Entity;

class Message
{
    private string $username;
    private string $message;
    private PDO $connection;

    public function __construct(string $username, string $message)
    {
        $this->username = $username;
        $this->message = $message;
        $this->connection = new PDO("mysql:host=localhost;dbname=messages", 'root', 'aGo90nPIi');
    }

    public function GetUsername() : string
    {
        return $this->username;
    }

    public function GetMessage() : string
    {
        return $this->message;
    }
    
    public function Add(Message $message) : bool
    {
        $messageText = $message->GetMessage();
        $username = $message->GetUsername();

        $query = $this->connection->prepare("INSERT INTO messages(message, username, datetime) VALUES (:messageText, :username, NOW()))";
        return $query->execute(['messageText' => $messageText, 'username' => $username]);
    }
	
    public function Delete(int $id) : bool
    {
	    $query = $this->connection->prepare('DELETE FROM messages WHERE id = :id');
        return $query->execute();
    }

    public function GetAll() : array
    {
        $query = $this->connection->prepare('SELECT message, username FROM messages');
	
	$query->execute();
	$data = $query->fetchAll();
        $messages = array();
        foreach ($data as $array){
            $messages[] = new Message($array['message'], $array['username']);
        }
	    
        return $messages;
    }
	
    public function GetById(int $id) : Message
    {
	$query = $this->pdo->prepare('SELECT * FROM messages WHERE id = :id');
	    
        $query->execute(['id' => $id]);
        $data = $query->fetch();
	
        return new Message($data['message'], $data['username']);
    }
}
