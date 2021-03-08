<?php


namespace App\Service;


use App\Entity\Blog;
use App\Entity\Message;


class MessageService extends ApiService
{

    public function getMessages(): array
    {
        return $this->getAll(Message::NAME);
    }
    public function deleteMessage(int $id){
        return $this->delete(Message::NAME, $id);
    }
    public function newMessage(Message $message){
        $this->post(Message::NAME, $message);
    }

    public function getMessage(int $id){
        return $this->get(Message::NAME, $id);
    }

}