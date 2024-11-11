<?php
require_once './app/models/Role.php';

class RoleRepository
{
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAllRoles()
    {
        $query = "SELECT r.id, r.value FROM roles r ORDER BY r.created_at DESC";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $roles ? $roles : []; // Trả về mảng rỗng nếu không có kết quả
    }


    public function createRole(Role $role)
    {
        $query = "INSERT INTO roles (value, created_at, updated_at) VALUES (:value, :created_at, :updated_at)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':value', $role->value);
        $stmt->bindParam(':created_at', $role->created_at);
        $stmt->bindParam(':updated_at', $role->updated_at);
        if ($stmt->execute()) {
            $role->id = $this->_db->lastInsertId(); // Lấy ID mới sau khi thêm
            return $role;
        }
        return null;
    }

    public function getRoleById($id)
    {
        $query = "SELECT * FROM roles WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRoleByValue($value)
    {
        $query = "SELECT * FROM roles WHERE value = :value"; // Đảm bảo rằng cột value tồn tại
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRole($id, Role $role)
    {
        $query = "UPDATE roles SET value = :value, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':value', $role->value);
        $stmt->bindParam(':updated_at', $role->updated_at);
        return $stmt->execute();
    }


    public function deleteRoleById($id)
    {
        $query = "DELETE FROM roles WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
