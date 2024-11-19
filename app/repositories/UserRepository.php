<?php

namespace App\Repositories;

use App\Data\Models\User;
use PDO;

class UserRepository
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }
    public function getAllUsers($limit, $page, $name)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT u.id, u.email, u.first_name, u.last_name, r.value
                  FROM users u
                  JOIN roles r ON u.role_id = r.id";

        if (!empty($name)) {
            $query .= " WHERE u.first_name LIKE :name OR u.last_name LIKE :name";
        }

        $query .= " ORDER BY u.updated_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->_db->prepare($query);

        if (!empty($name)) {
            $nameParam = '%' . $name . '%';
            $stmt->bindValue(':name', $nameParam, \PDO::PARAM_STR);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        $totalQuery = "SELECT COUNT(*) AS total FROM users u";
        if (!empty($name)) {
            $totalQuery .= " WHERE u.first_name LIKE :name OR u.last_name LIKE :name";
        }

        $totalStmt = $this->_db->prepare($totalQuery);

        if (!empty($name)) {
            $totalStmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }

        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['users' => $users, 'total' => $total];
    }
    public function getUserById($id)
    {
        $query = "SELECT u.*, r.value AS value
                  FROM users u
                  JOIN roles r ON u.role_id = r.id
                  WHERE u.id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function createUser(User $user)
    {
        $query = "INSERT INTO users (first_name, last_name, email, password, role_id)
                  VALUES (:first_name, :last_name, :email, :password, :role_id)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':first_name', $user->first_name);
        $stmt->bindParam(':last_name', $user->last_name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':role_id', $user->role_id);
        if ($stmt->execute()) {
            $user->id = $this->_db->lastInsertId();
            return $user;
        }
        return null;
    }
    public function updateUser($id, User $user)
    {
        $query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, role_id = :role_id, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':first_name', $user->first_name);
        $stmt->bindParam(':last_name', $user->last_name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':role_id', $user->role_id);
        $stmt->bindParam(':updated_at', $user->updated_at);
        return $stmt->execute();
    }
    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function deleteUserById($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
