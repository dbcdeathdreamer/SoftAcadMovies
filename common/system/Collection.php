<?php

abstract class Collection {

    protected $entity = 'Entity';
    protected $table  = 'Table';
    protected $db     = 'DB';

    abstract public function save();

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getOne($where = [])
    {
        $query = "SELECT * FROM {$this->table}
        WHERE 1
        ";

        $where = $this->escape($where);

        foreach ($where as $key => $value) {
            $query.= " AND {$key} = '{$value}' ";
        }

        $query.= "
            LIMIT 1
        ";

        $result = $this->db->query($query);

        if (!$result) {
            $this->db->error();
        }

        $row = $this->db->translate($result);
        $entity = new $this->entity();

        return $entity->init($row);;
    }

    public function get($where = [], $offset = -1, $limit = 5)
    {
        $query = "SELECT * FROM {$this->table}
        WHERE 1 
        ";

        $where = $this->escape($where);

        foreach ($where as $key => $value) {
            $query.= " AND {$key} = '{$value}' ";
        }

        if ($offset >= 0) {
            $query .= " LIMIT {$offset}, {$limit} ";
        }


        $result = $this->db->query($query);

        if (!$result) {
            $this->db->error();
        }

        $rows = [];
        while ($row = $this->db->translate($result)) {
            $entity = new $this->entity();
            $entity->init($row);
            $rows[] = $entity;
        }


        return $rows;
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

    protected function escape($data) {

        $escapeData = [];
        foreach ($data as $key => $value) {
            $escapeData[$key] = mysqli_real_escape_string($this->connection, $value);
        }

        return $escapeData;
    }

}