<?php

class Action
{
    private $table = 'actions';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getActions($search = null)
    {
        $query = "SELECT * 
                  FROM actions
                  WHERE deleted_at IS NULL";

        if (!empty($search)) {
            $query .= " AND (
                            actions.name LIKE '%$search%')
                            OR (actions.description LIKE '%$search%'
                            )";
        } 

       

        // if (empty($search)) {
        //     $query .= " AND (
        //                     actions.name LIKE '%$search%')
        //                     OR description LIKE '%$search%'
        //                     )";
        // }

        $this->db->query($query);

        return $this->db->resultSet();
    }

    public function getActionById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id AND deleted_at IS NULL LIMIT 1");

        $this->db->bind('id', $id);

        return $this->db->single();
    }

    public function findByName($name)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE name = :name LIMIT 1");

        $this->db->bind('name', $name);

        return $this->db->single();
    }  

    public function createAction($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (id, name, description, created_at, updated_at) 
                  VALUES (UUID(), :name, :description, NOW(), NOW())";

        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);

        return $this->db->execute();
    }

    public function updateAction($id, $data)
    {
        if (!empty($data['password'])) {
            $query = "UPDATE " . $this->table . " 
                      SET name = :name, 
                          description = :description, 
                          updated_at = NOW() 
                      WHERE id = :id AND deleted_at IS NULL";
        } else {
            $query = "UPDATE " . $this->table . " 
                      SET name = :name, 
                          description = :description, 
                          updated_at = NOW() 
                      WHERE id = :id AND deleted_at IS NULL";
        }

        $this->db->query($query);

        $this->db->bind('id', $id);
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);

        return $this->db->execute();
    }

    public function deleteAction($id)
    {
        $this->db->query("UPDATE " . $this->table . " SET deleted_at = NOW() WHERE id = :id");

        $this->db->bind('id', $id);

        return $this->db->execute();
    }

    public function restoreAction($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, 
                      description = :description, 
                      updated_at = NOW(), 
                      deleted_at = NULL 
                  WHERE id = :id";

        $this->db->query($query);

        $this->db->bind('id', $id);
        $this->db->bind('name', $data['name']);
        $this->db->bind('description', $data['description']);

        return $this->db->execute();
    }
}
