<?php

namespace App\forms\common;

class BaseForm
{
    public array $errors = [];
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}