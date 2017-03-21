<?php

class DB
{
    const DB_HOST       = 'localhost';
    const DB_USERNAME   = 'root';
    const DB_PASSWORD   = '';
    const DB_NAME       = 'movies';


    static private  $instance;
    private $connection;


    static public function getInstance()
    {

        if (!self::$instance instanceof DB) {
            self::$instance = new DB;
        }

        return self::$instance;
//        //Това е проверка за това дали съществъва създадена инстанция на този клас
//        if (self::$instance instanceof DB) {
//            //тук се връща старата инстанция ако има такава вече създадена
//            $inst = self::$instance;
//        } else {
//            //тък се създава нова инстанция на класа ако проверката е показала че не същестъва такава
//            $inst = new DB();
//            self::$instance = $inst;
//        }
//
//        return $inst;

    }

    // Този метод се изпълнява при създаването на инстанция на класа DB
    private function __construct()
    {
        $conn = mysqli_connect(self::DB_HOST , self::DB_USERNAME, self::DB_PASSWORD, self::DB_NAME);

        if (!$conn) {
            echo  mysqli_connect_error(); die;
        }

        $this->connection = $conn;
    }


    //Чрез този метод ще правим SELECT запитвания към базата данни
    public function get($table, $where = [])
    {
        $query = "SELECT * FROM {$table}
        WHERE 1 
        ";

        $where = $this->escape($where);

        foreach ($where as $key => $value) {
            $query.= " AND {$key} = '{$value}' ";
        }


        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            $this->error();
        }

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }


        return $rows;
    }

    public function getOne($table, $where = [])
    {
        $query = "SELECT * FROM {$table}
        WHERE 1
        ";

        $where = $this->escape($where);

        foreach ($where as $key => $value) {
            $query.= " AND {$key} = '{$value}' ";
        }

        $query.= "
            LIMIT 1
        ";

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            $this->error();
        }

        $row = mysqli_fetch_assoc($result);

        return $row;
    }

    public function insert($table, $data)
    {
        $query = "INSERT INTO {$table} SET";

        $data = $this->escape($data);
        $i = 0;
        foreach ($data as $key => $value) {
            ++$i;
            if ($i == count($data)) {
                $query.= " {$key} = '{$value}'  ";
            } else {
                $query.= " {$key} = '{$value}',  ";
            }
        }

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            $this->error();
        }

        return mysqli_affected_rows($this->connection);
    }


    public function update($table, $data, $where = [])
    {
        $query = "UPDATE {$table} SET";

        $data = $this->escape($data);
        $where = $this->escape($where);
        $i = 0;
        foreach ($data as $key => $value) {
            ++$i;
            if ($i == count($data)) {
                $query.= " {$key} = '{$value}'  ";
            } else {
                $query.= " {$key} = '{$value}',  ";
            }
        }
        $query .= " WHERE 1 ";
        foreach ($where as $key => $value) {
            $query .= " AND {$key} = '{$value}' ";
        }

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            $this->error();
        }

        return mysqli_affected_rows($this->connection);
    }

    public function delete($table, $where = [])
    {
        $query = "DELETE FROM {$table} WHERE 1";

        $where = $this->escape($where);
        foreach ($where as $key => $value) {
            $query.= " AND {$key} = '{$value}'";
        }

        $result = mysqli_query($this->connection, $query);
        if (!$result) {
            $this->error();
        }

        return mysqli_affected_rows($this->connection);
    }


    private function escape($data) {

        $escapeData = [];
        foreach ($data as $key => $value) {
            $escapeData[$key] = mysqli_real_escape_string($this->connection, $value);
        }

        return $escapeData;
    }

    private function error()
    {
        echo mysqli_error($this->connection); die;
    }

}