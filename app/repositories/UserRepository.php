<?php
require_once './app/models/User.php';

class UserRepository  {
    protected $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getAllUsers() {
        $query = "SELECT u.id, u.username, u.email, u.first_name, u.last_name, r.value AS role_name
                  FROM users u
                  JOIN roles r ON u.role_id = r.id";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUserById($id) {
        $query = "SELECT u.*, r.value AS value
                  FROM users u
                  JOIN roles r ON u.role_id = r.id
                  WHERE u.id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addUser(User $user) {
        $query = "INSERT INTO users (first_name, last_name, email, phone, password, avatar, role_id, created_at)
                  VALUES (:first_name, :last_name, :email, :phone, :password, :avatar, :role_id, :created_at)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':first_name', $user->first_name);
        $stmt->bindParam(':last_name', $user->last_name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':phone', $user->phone);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':avatar', $user->avatar);
        $stmt->bindParam(':role_id', $user->role_id);
        $stmt->bindParam(':created_at', $user->created_at);
    
        if ($stmt->execute()) {
            $user->id = $this->_db->lastInsertId(); // Lấy ID mới sau khi thêm
            return $user;
        }
        return null;
    }
    

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về người dùng nếu tồn tại
    }

    public function deleteUserById($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
}