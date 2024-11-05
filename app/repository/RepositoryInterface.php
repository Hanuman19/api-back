<?php

namespace App\repository;

interface RepositoryInterface
{
    public function execute(string $query): void;
    public function all(): array;
    public function one();
}