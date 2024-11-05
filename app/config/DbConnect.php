<?php

namespace App\config;
class DbConnect
{
    public static function getConnection()
    {
        return pg_connect(
            "host=localhost
        port=5432 
        dbname=test_api 
        user=postgres 
        password=''
        ");

    }
}