<?php

namespace App\repository;

use App\config\DbConnect;

class BaseRepository implements RepositoryInterface
{
    private $items;
    public function execute(string $query): void
    {
        $this->items = pg_query(DbConnect::getConnection(), $query);
    }

    public function all(): array
    {
        $itemsList = [];
        if (!empty($this->items)) {
            foreach (pg_fetch_all($this->items) as $item) {
                $itemsList[] = $item;
            }
        }

        return $itemsList;
    }
    public function one(): object|bool
    {
        return pg_fetch_object($this->items);
    }
}