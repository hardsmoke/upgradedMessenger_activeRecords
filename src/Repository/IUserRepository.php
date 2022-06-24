<?php

namespace Messenger\Repository;

use Messenger\Model\User;

interface IUserRepository
{
    public function Save(User $user);
}