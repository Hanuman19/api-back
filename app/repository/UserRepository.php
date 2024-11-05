<?php

namespace App\repository;

use App\forms\users\CreateUserForm;
use App\forms\users\UpdateUserForm;

class UserRepository extends BaseRepository
{
    public function getUsers(): array
    {
        $query = "SELECT * FROM users";
        $this->execute($query);
        return $this->all();
    }

    public function getOneById(int $id): object|bool
    {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $this->execute($query);
        return $this->one();
    }

    public function create(CreateUserForm $form): bool
    {
        try {
            $query = "INSERT INTO users (name, email) Values ('$form->name', '$form->email')";
            $this->execute($query);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
    public function update(int $id, UpdateUserForm $form): bool
    {
        try {
            $query = "UPDATE users SET name = '$form->name', email = '$form->email' WHERE id = '$id'";
            $this->execute($query);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM users WHERE id = '$id'";
            $this->execute($query);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function getUserByEmail(string $email): object|bool
    {
        $query = "SELECT id FROM users WHERE email = '$email'";
        $this->execute($query);
        return $this->one();
    }
}