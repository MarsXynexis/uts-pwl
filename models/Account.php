<?php

class Account
{
    private $table = 'accounts';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAccounts($search = null)
    {
        $query = "SELECT accounts.*, account_type.name AS account_type_name 
                  FROM accounts 
                  LEFT JOIN account_type ON accounts.account_type_id = account_type.id 
                  WHERE accounts.deleted_at IS NULL";

        if (!empty($search)) {
            $query .= " AND (accounts.name LIKE :search 
                         OR accounts.email LIKE :search 
                         OR accounts.identification_number LIKE :search 
                         OR account_type.name LIKE :search)";
        }

        $query .= " ORDER BY accounts.created_at DESC";

        $this->db->query($query);

        if (!empty($search)) {
            $this->db->bind('search', '%' . $search . '%');
        }

        return $this->db->resultSet();
    }


    public function getUsedAccountTypes()
    {
        $this->db->query("SELECT DISTINCT account_type_id FROM accounts WHERE deleted_at IS NULL");

        return $this->db->resultSet();
    }

    public function getAccountById($id)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE id = :id AND deleted_at IS NULL LIMIT 1");

        $this->db->bind('id', $id);

        return $this->db->single();
    }

    public function findByEmail($email)
    {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1");

        $this->db->bind('email', $email);

        return $this->db->single();
    }

    public function createAccount($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at) 
                  VALUES (UUID(), :name, :email, :password, :account_type_id, :status, :identification_number, :identification_type, NOW(), NOW())";

        $this->db->query($query);

        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('account_type_id', $data['account_type_id']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('identification_number', $data['identification_number']);
        $this->db->bind('identification_type', $data['identification_type']);

        return $this->db->execute();
    }

    public function updateAccount($id, $data)
    {
        if (!empty($data['password'])) {
            $query = "UPDATE " . $this->table . " 
                      SET name = :name, 
                          email = :email, 
                          password = :password, 
                          account_type_id = :account_type_id, 
                          status = :status, 
                          identification_number = :identification_number, 
                          identification_type = :identification_type, 
                          updated_at = NOW() 
                      WHERE id = :id AND deleted_at IS NULL";
        } else {
            $query = "UPDATE " . $this->table . " 
                      SET name = :name, 
                          email = :email, 
                          account_type_id = :account_type_id, 
                          status = :status, 
                          identification_number = :identification_number, 
                          identification_type = :identification_type, 
                          updated_at = NOW() 
                      WHERE id = :id AND deleted_at IS NULL";
        }

        $this->db->query($query);

        $this->db->bind('id', $id);
        $this->db->bind('name', $data['name']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('account_type_id', $data['account_type_id']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('identification_number', $data['identification_number']);
        $this->db->bind('identification_type', $data['identification_type']);

        if (!empty($data['password'])) {
            $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        }

        return $this->db->execute();
    }

    public function deleteAccount($id)
    {
        $this->db->query("UPDATE " . $this->table . " SET deleted_at = NOW() WHERE id = :id");

        $this->db->bind('id', $id);

        return $this->db->execute();
    }

    public function restoreAccount($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, 
                      password = :password, 
                      account_type_id = :account_type_id, 
                      status = :status, 
                      identification_number = :identification_number, 
                      identification_type = :identification_type, 
                      updated_at = NOW(), 
                      deleted_at = NULL 
                  WHERE id = :id";

        $this->db->query($query);

        $this->db->bind('id', $id);
        $this->db->bind('name', $data['name']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('account_type_id', $data['account_type_id']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('identification_number', $data['identification_number']);
        $this->db->bind('identification_type', $data['identification_type']);

        return $this->db->execute();
    }
}
