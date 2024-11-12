<?php
require_once './app/models/Role.php';

class RoleRepository
{
    protected $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }
    public function getAllRoles(QueryParamsDTO $queryParams)
    {
        // Calculate offset based on the current page and limit
        $offset = ($queryParams->page - 1) * $queryParams->limit;

        // Build the main query with optional search
        $query = "SELECT r.id, r.value FROM roles r";
        if (!empty($queryParams->name)) {
            $query .= " WHERE r.value LIKE :name";
        }

        // Add sorting and limit/offset for pagination
        $query .= " ORDER BY r.created_at DESC LIMIT :limit OFFSET :offset";

        // Prepare and bind parameters
        $stmt = $this->_db->prepare($query);
        if (!empty($queryParams->name)) {
            $nameParam = '%' . $queryParams->name . '%';
            $stmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int) $queryParams->limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        // Execute the query and return results
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function getTotalRolesCount($name = null)
    {
        // Base query to count total roles
        $query = "SELECT COUNT(*) as total FROM roles";
        if (!empty($name)) {
            $query .= " WHERE value LIKE :name";
        }

        // Prepare and bind parameters for search if applicable
        $stmt = $this->_db->prepare($query);
        if (!empty($name)) {
            $nameParam = '%' . $name . '%';
            $stmt->bindParam(':name', $nameParam, PDO::PARAM_STR);
        }

        // Execute the query and return total count
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
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
}
