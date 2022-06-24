<?php

namespace Messenger\Model\Mapper;

class MessageMapper
{
    private PDO $connection;

    public function __construct(string $dbHost, string $dbName, string $dbUsername, string $dbPassword)
    {
        $this->connection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    }
	
    public function Add(Message $message) : bool
    {
        $messageText = $message->GetMessage();
        $username = $message->GetUsername();

        $query = "INSERT INTO messages(message, username, datetime) VALUES ('$messageText', '$username', NOW())";
	    
        return $this->connection->query($query);
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
