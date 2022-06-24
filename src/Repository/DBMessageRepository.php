<?php

namespace Messenger\Repository;

use Messenger\Model\Entity\Message;
use Messenger\Model\Mapper\MessageMapper;

class DBMessageRepository implements IMessageRepository
{
    private Message $messagemapper;

    public function __construct(Message $messagemapper)
    {
        $this->messagemapper = $messagemapper;
    }

    public function Add(Message $message)
    {
        $this->messagemapper->Add($message);
    }
    
    public function Delete(int $id)
    {
        $this->messagemapper->Delete($id);
    }
    
    public function GetAll()
    {
        return $this->messagemapper->GetAll();
    }
    
    public function GetById(int $id)
    {
        return $this->messagemapper->GetById($id);
    }
}
