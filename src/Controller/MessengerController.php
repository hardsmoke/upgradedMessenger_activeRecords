<?php

namespace Messenger\Controller;

use Messenger\Model\Message;
use Messenger\Repository\IMessageRepository;
use Messenger\View\MessengerView;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MessengerController
{
    private IMessageRepository $messageRepository;
    private MessengerView $messengerView;
    private Logger $logger;

    public function __construct(MessengerView $messengerView, IMessageRepository $messageRepository)
    {
        $this->logger = new Logger('messages');
        $this->logger->pushHandler(new StreamHandler(dirname(__DIR__) . '/chat.log', Logger::INFO));
        $this->messengerView = $messengerView;
        $this->messageRepository = $messageRepository;
    }

    public function SendMessage(string $username, string $messageText)
    {
        $message = new Message($username, $messageText);
        $this->logger->info('message', ['username' => $username, 'message' => $messageText]);

        $this->messageRepository->Save($message);
    }

    public function GetAll() : array
    {
        return $this->messageRepository->GetAll();
    }
}