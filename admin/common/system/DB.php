<?php

class DB
{
    const DB_HOST       = 'localhost';
    const DB_USERNAME   = 'root';
    const DB_PASSWORD   = '';
    const DB_NAME       = 'movies';

    //Връзка към базата данни
    private $connection;


    // Този метод се изпълнява при създаването на инстанция на класа DB
    public function __construct()
    {
        $conn = mysqli_connect(self::DB_HOST , self::DB_USERNAME, self::DB_PASSWORD, self::DB_NAME);

        if (!$conn) {
            echo '<pre>';
            return var_dump( mysqli_connect_error());
        }

        $this->connection = $conn;
    }


    //Чрез този метод ще правим SELECT запитвания към базата данни
    public function get()
    {

    }

    public function insert()
    {

    }


    public function update()
    {

    }

    public function delete()
    {

    }



}