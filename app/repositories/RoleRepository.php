<?php
require_once './app/models/Role.php';

class RoleRepository  {
    protected $_db;

    public function __construct($db) {
        $this->_db = $db;
    }

    public function getAllRoles() {
        $query = "SELECT r.value FROM roles r OrderBy( DESC, r.created_at )";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createRole(Role $role) {
        $query = "INSERT INTO roles (value) VALUES (:value)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':value', $role->value);
        if ($stmt->execute()) {
            $role->id = $this->_db->lastInsertId(); // Lấy ID mới sau khi thêm
            return $role;
        }
        return null;
    }
    
    public function getRoleByValue($value) {
        $query = "SELECT * FROM users WHERE value = :value";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về người dùng nếu tồn tại
    }
}