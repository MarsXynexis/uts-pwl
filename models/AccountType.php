<?php

class AccountType
{
    private $table = 'account_type';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAccountType($search = null)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE deleted_at IS NULL";

        if (!empty($search)) {
            $query .= " AND (name LIKE :search OR description LIKE :search)";
        }

        $query .= " ORDER BY created_at DESC";

        $this->db->query($query);

        if (!empty($search)) {
            $this->db->bind('search', '%' . $search . '%');
        }

        return $this->db->resultSet();
    }

    public function getAccountTypeById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id AND deleted_at IS NULL LIMIT 1");

        $this->db->bind('id', $id);

        return $this->db->single();
    }

    public function createAccountType($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (id, name, description, created_at, updated_at) 
                  VALUES (UUID(), :name, :description, NOW(), NOW())";

        $this->db->query($query);

        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);

        return $this->db->execute();
    }

    public function updateAccountType($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, 
                      description = :description, 
                      updated_at = NOW() 
                  WHERE id = :id AND deleted_at IS NULL";

        $this->db->query($query);

        $this->db->bind('id', $id);
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);

        return $this->db->execute();
    }

    public function deleteAccountType($id)
    {
        $this->db->query("UPDATE " . $this->table . " SET deleted_at = NOW() WHERE id = :id");

        $this->db->bind('id', $id);

        return $this->db->execute();
    }
}
