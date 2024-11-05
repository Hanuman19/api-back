<?php

namespace App\controllers;

use App\forms\users\CreateUserForm;
use App\forms\users\UpdateUserForm;
use App\http\response\BaseResponse;
use App\http\response\Users\UsersResponse;
use App\repository\UserRepository;

class UserController extends Controller
{
    public $apiName = 'users';
    private UsersResponse $response;

    public function __construct(UserRepository $repository)
    {
        $this->response = new UsersResponse();
        parent::__construct($repository);
    }

    protected function indexAction(): false|string
    {
        $users = $this->repository->getUsers();
        $this->response->items = $users;
        $this->response->success = true;
        return json_encode($this->response);
    }

    protected function viewAction(): false|string
    {
        if (!isset($this->id)) {
            http_response_code(404);
            $this->response->success = false;
            $this->response->setMessages('Page not found');
            return json_encode($this->response);
        }
        $user = $this->repository->getOneById($this->id);
        if ($user) {
            $this->response->items[] = $user;
        }
        $this->response->success = true;
        return json_encode($this->response);
    }

    protected function createAction(): string
    {
        $response = new BaseResponse();
        $form = new CreateUserForm($this->repository);
        $form->fill($_POST);
        if (!$form->validate()) {
            $response->success = false;
            $response->setMessages($form->errors);
            return json_encode($response);
        }
        try {
            http_response_code(201);
            $this->repository->create($form);
            $response->success = true;
        } catch (\Exception $e) {
            http_response_code(500);
            $response->success = false;
            $response->setMessages('Ошибка созданения');
        }
        return json_encode($response);
    }

    protected function updateAction(): string
    {
        $response = new BaseResponse();
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $form = new UpdateUserForm($this->repository);
        $form->fill($data);
        $form->id = $this->id;
        if (!$form->validate()) {
            $response->success = false;
            $response->setMessages($form->errors);
            return json_encode($response);
        }
        if (!isset($this->id)) {
            http_response_code(404);
            $response->success = false;
            $response->setMessages('Page not found');
            return json_encode($response);
        }

        $this->repository->update($this->id, $form);
        $response->success = true;
        return json_encode($response);
    }

    protected function deleteAction(): string
    {
        $response = new BaseResponse();
        if (!isset($this->id)) {
            http_response_code(404);
            $response->success = false;
            $response->setMessages('Page not found');
            return json_encode($response);
        }
        $this->repository->delete($this->id);
        $response->success = true;
        return json_encode($response);
    }
}