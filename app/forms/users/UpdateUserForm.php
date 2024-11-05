<?php

namespace App\forms\users;

use App\forms\common\BaseForm;
use App\repository\BaseRepository;

class UpdateUserForm extends BaseForm
{
    private BaseRepository $repository;
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }
    public ?string $name = null;
    public ?string $email = null;
    public ?int $id = null;

    public function validate(): bool
    {
        if (!$this->name) {
            $this->errors[] = 'Поле name обязательно для заполнения';
        }
        if ($this->name && strlen($this->name) > 50) {
            $this->errors[] = 'Длина строки name не должна привышать 50 символов';
        }
        if (!$this->email) {
            $this->errors[] = 'Поле email обязательно для заполнения';
        }
        if ($this->email) {
            $user = $this->repository->getUserByEmail($this->email);
            if ($user && $user->id != $this->id) {
                $this->errors[] = 'Данный email уже используется';
            }
        }
        return empty($this->errors);
    }
}