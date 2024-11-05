<?php

namespace App\routers;

use App\controllers\Controller;
use App\controllers\UserController;
use App\repository\UserRepository;

class Router
{
    /**
     * @throws \Exception
     */
    public function route(?string $type): Controller
    {
        return match ($type) {
            'users' => new UserController(
                new UserRepository()
            ),
            'default' => Throw new \Exception('Not found')
        };
    }
}