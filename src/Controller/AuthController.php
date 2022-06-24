<?php

namespace Messenger\Controller;

use Messenger\View\AuthView;
use Messenger\Model\User;
use Messenger\Repository\IUserRepository;

class AuthController
{
    private AuthView $authView;
    private IUserRepository $userRepository;

    public function __construct(AuthView $authView, IUserRepository $userRepository)
    {
        $this->authView = $authView;
        $this->userRepository = $userRepository;
    }

    public function Login(string $username, $password) : string
    {
        $currentUser = $this->userRepository->FindByUsername($username);

        if ($currentUser->GetUsername() == '')
        {
            return 'ACCOUNT NOT FOUND';
        }
        else
        {
            if ($currentUser->GetPassword() == $password)
            {
                setcookie('user', json_encode($currentUser));

                header('Location: /');

                return 'Loading...';
            }

            return 'PASSWORD IS WRONG';
        }
    }

    public function Register(string $username, string $password) : string
    {
        $this->userRepository->Save(new User($username, $password));

        header('Location: /signin');

        return $this->authView->Render('SigninPage.twig');
    }
}
