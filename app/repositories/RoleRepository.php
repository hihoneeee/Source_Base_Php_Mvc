<?php
require_once './app/models/Role.php';

class RoleRepository
{
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }
    public function getAllRoles($limit, $page, $name)
    {
        $offset = ($page - 1) * $limit;

        // Xây dựng truy vấn lấy danh sách roles
        $query = "SELECT * FROM roles r";
        if (!empty($name)) {
            $query .= " WHERE r.value LIKE :name";
        }
        $query .= " ORDER BY r.created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->_db->prepare($query);
        if (!empty($name)) {
            $nameParam = '%' . $name . '%';
            $stmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Tính tổng số roles với điều kiện tìm kiếm (nếu có)
        $totalQuery = "SELECT COUNT(*) AS total FROM roles";
        if (!empty($name)) {
            $totalQuery .= " WHERE value LIKE :name";
        }
        $totalStmt = $this->_db->prepare($totalQuery);
        if (!empty($name)) {
            $totalStmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['roles' => $roles, 'total' => $total];
    }

    public function getListRole()
    {
        $query = "SELECT * FROM roles";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function createRole(Role $role)
    {
        $query = "INSERT INTO roles (value, created_at, updated_at) VALUES (:value, :created_at, :updated_at)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':value', $role->value);
        $stmt->bindParam(':created_at', $role->created_at);
        $stmt->bindParam(':updated_at', $role->updated_at);
        if ($stmt->execute()) {
            $role->id = $this->_db->lastInsertId();
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
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getRoleByValue($value)
    {
        $query = "SELECT * FROM roles WHERE value = :value";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
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

    public function getRoleDetail($roleId)
    {
        // Lấy thông tin Role
        $queryRole = "SELECT * FROM roles WHERE id = :role_id";
        $stmtRole = $this->_db->prepare($queryRole);
        $stmtRole->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmtRole->execute();
        $role = $stmtRole->fetch(PDO::FETCH_OBJ);

        if (!$role) {
            return null;
        }

        // Lấy danh sách User có role_id tương ứng
        $queryUsers = "SELECT * FROM users WHERE role_id = :role_id";
        $stmtUsers = $this->_db->prepare($queryUsers);
        $stmtUsers->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmtUsers->execute();
        $users = $stmtUsers->fetchAll(PDO::FETCH_OBJ);

        return ['role' => $role, 'users' => $users];
    }
}
