<?php

namespace Messenger\Repository;

use Messenger\Model\Entity\User;
use Messenger\Model\Mapper\UserMapper;

class DBUserRepository implements IUserRepository
{
    private UserMapper $usermapper;

    public function __construct(UserMapper $usermapper)
    {
        $this->usermapper = $usermapper;
    }

    public function Add(User $user)
    {
        $this->usermapper->Add($user);
    }
    
    public function FindByName(string $username)
    {
        return $this->usermapper->FindByName($username);
    }
    
    public function Delete(int $id)
    {
        $this->usermapper->Delete($id);
    }
    
    public function GetAll()
    {
        return $this->usermapper->GetAll();
    }
    
    public function GetById(int $id)
    {
        return $this->usermapper->GetById($id);
    }
}
