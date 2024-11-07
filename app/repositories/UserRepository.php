<?php
require_once './app/models/User.php';

class UserRepository  {
    protected $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getAllUsers() {
        // Include the 'id' field in the SELECT statement
        $query = "SELECT id, username, email, first_name, last_name FROM users";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser(User $user) {
        $query = "INSERT INTO users (Username, First_Name, Last_Name, Email) VALUES (:username, :firstName, :lastName, :email)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':username', $user->username);
        $stmt->bindParam(':firstName', $user->firstName);
        $stmt->bindParam(':lastName', $user->lastName);
        $stmt->bindParam(':email', $user->email);
        
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