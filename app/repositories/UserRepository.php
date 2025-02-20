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
    public function getAllUsers($limit, $page, $name, $roleId = null)
    {
        $offset = ($page - 1) * $limit;

        // Bắt đầu câu truy vấn
        $query = "SELECT u.id, u.email, u.first_name, u.last_name, r.value
                  FROM users u
                  JOIN roles r ON u.role_id = r.id";

        // Điều kiện WHERE động
        $conditions = [];
        if (!empty($name)) {
            $conditions[] = "(u.first_name LIKE :name OR u.last_name LIKE :name)";
        }
        if (!empty($roleId)) {
            $conditions[] = "u.role_id != :roleId";
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY u.updated_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->_db->prepare($query);

        // Gắn giá trị tham số
        if (!empty($name)) {
            $nameParam = '%' . $name . '%';
            $stmt->bindValue(':name', $nameParam, \PDO::PARAM_STR);
        }
        if (!empty($roleId)) {
            $stmt->bindValue(':roleId', $roleId, \PDO::PARAM_INT);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Câu truy vấn tính tổng
        $totalQuery = "SELECT COUNT(*) AS total FROM users u
                       JOIN roles r ON u.role_id = r.id";

        if (!empty($conditions)) {
            $totalQuery .= " WHERE " . implode(" AND ", $conditions);
        }

        $totalStmt = $this->_db->prepare($totalQuery);

        // Gắn giá trị tham số cho câu truy vấn tổng
        if (!empty($name)) {
            $totalStmt->bindValue(':name', $nameParam, \PDO::PARAM_STR);
        }
        if (!empty($roleId)) {
            $totalStmt->bindValue(':roleId', $roleId, \PDO::PARAM_INT);
        }
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['users' => $users, 'total' => $total];
    }


    public function getAll($roleId = null)
    {
        $query = "
            SELECT u.id, 
            CONCAT(u.first_name, ' ', u.last_name) AS fullname
            FROM users u
        ";

        if (!empty($roleId)) {
            $query .= " WHERE u.role_id != :roleId";
        }

        $stmt = $this->_db->prepare($query);
        if (!empty($roleId)) {
            $stmt->bindValue(':roleId', $roleId, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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

    public function getProfileById($id)
    {
        $queryUser = "SELECT u.*, r.value
                      FROM users u
                      JOIN roles r ON u.role_id = r.id
                      WHERE u.id = :id";
        $stmt = $this->_db->prepare($queryUser);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $queryPost = "SELECT p.*, pd.content, pd.title, pd.meta, pd.avatar, c.id as categoryId, c.title as categoryTitle
                      FROM posts p
                      JOIN categories c ON p.category_id = c.id
                      JOIN postDetail pd ON p.id = pd.post_id
                      WHERE p.user_id = :id AND p.status = 'completed'
                      ORDER BY p.updated_at DESC";
        $stmt = $this->_db->prepare($queryPost);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $queryTotal = "SELECT COUNT(*) as total
                       FROM posts
                       WHERE user_id = :id AND status = 'completed'";
        $stmt = $this->_db->prepare($queryTotal);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_OBJ)->total;

        return [
            'user' => $user,
            'posts' => $posts,
            'total' => $total
        ];
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
        $query = "UPDATE users 
                  SET first_name = :first_name, 
                      last_name = :last_name, 
                      email = :email, 
                      role_id = :role_id, 
                      avatar = :avatar, 
                      updated_at = :updated_at 
                  WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':first_name', $user->first_name);
        $stmt->bindParam(':last_name', $user->last_name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':role_id', $user->role_id);
        $stmt->bindParam(':avatar', $user->avatar);
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

    public function updatePassowrd($id, $password, $updatedAt)
    {
        $query = "UPDATE users 
                  SET password = :password, 
                      updated_at = :updated_at 
                  WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':updated_at', $updatedAt);
        return $stmt->execute();
    }

    public function deleteUserById($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
