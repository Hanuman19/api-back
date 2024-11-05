<?php

namespace App\http\response;
class BaseResponse
{
    public bool $success = false;
    public array $message = [];


    public function setMessages(array|string $messages): void
    {
        if (is_array($messages)) {
            $this->message = $messages;
        }
        if (is_string($messages)) {
            $this->message[] = $messages;
        }

    }
}