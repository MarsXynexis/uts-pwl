<?php

class Account
{
    private $table = 'accounts';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE deleted_at IS NULL");
        return $this->db->resultSet();
    }
}
