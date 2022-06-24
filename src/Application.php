<?php

namespace Messenger;

use Messenger\Controller\AuthController;
use Messenger\Controller\MessengerController;
use Messenger\DI\ServiceLocator;
use Messenger\Repository\DBMessageRepository;
use Messenger\Repository\DBUserRepository;
use Messenger\View\AuthView;
use Messenger\View\MessengerView;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Application
{
    private ServiceLocator $serviceLocator;

    public function __construct()
    {
        $this->serviceLocator = $this->InitializeServices();
    }

    public function InitializeServices() : ServiceLocator
    {
        $serviceLocator = new ServiceLocator();

        $serviceLocator->Set('twig',
            new Environment(
                new FilesystemLoader(dirname(__DIR__) . '/templates')));

        $config = include('../public/config.php');
        $serviceLocator->Set(AuthController::class,
            new AuthController(
                new AuthView($serviceLocator->Get('twig')),
                new DBUserRepository($config['dbHost'], $config['dbUsersTable'], $config['dbUsername'], $config['dbPassword'])));

        $serviceLocator->Set(MessengerController::class,
            new MessengerController(
                new MessengerView($serviceLocator->Get('twig')),
                new DBMessageRepository($config['dbHost'], $config['dbMessagesTable'], $config['dbUsername'], $config['dbPassword'])));

        return $serviceLocator;
    }

    public function run() : string
    {
        if ($_COOKIE['user'] != null)
        {
            if ($_GET['action'] === 'logout')
            {
                unset($_COOKIE['user']);
                setcookie('user', '', time() - 3600, '/');

                header('Location: /signin');

                return $this->serviceLocator->Get('twig')->render('SigninPage.twig');
            }

            if (!empty($_POST) && $_GET['action'] === 'send-message')
            {
                $this->serviceLocator->Get(MessengerController::class)->
                SendMessage(json_decode($_COOKIE['user'], true)['username'], $_POST['message']);
            }

            $messages = $this->serviceLocator->Get(MessengerController::class)->GetAll();
            return $this->serviceLocator->Get('twig')->render('MessengerPage.twig',
                ['messages' => $messages]);
        }

        if ($_SERVER['REQUEST_URI'] === '/signin')
        {
            if (empty($_POST))
            {
                return $this->serviceLocator->Get('twig')->render('SigninPage.twig');
            }
            return $this->serviceLocator->Get(AuthController::class)->Login($_POST['username'], $_POST['password']);
        }

        if ($_SERVER['REQUEST_URI'] === '/signup')
        {
            if (empty($_POST))
            {
                return $this->serviceLocator->Get('twig')->render('SignupPage.twig');
            }
            return $this->serviceLocator->Get(AuthController::class)->Register($_POST['username'], $_POST['password']);
        }

        header('Location: /signup');
        return $this->serviceLocator->Get('twig')->render('SignupPage.twig');
    }
}
