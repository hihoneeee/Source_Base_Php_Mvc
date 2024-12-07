<?php

namespace App\Repositories;

use App\Data\Models\Category;
use PDO;

class CategoryRepository
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function getAllCategories($limit, $page, $name)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM categories";
        if (!empty($name)) {
            $query .= " WHERE title LIKE :name";
        }
        $query .= " ORDER BY updated_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->_db->prepare($query);
        if (!empty($name)) {
            $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Count total categories
        $totalQuery = "SELECT COUNT(*) AS total FROM categories";
        if (!empty($name)) {
            $totalQuery .= " WHERE title LIKE :name";
        }
        $totalStmt = $this->_db->prepare($totalQuery);
        if (!empty($name)) {
            $totalStmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
        }
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['categories' => $categories, 'total' => $total];
    }

    public function getListCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function createCategory(Category $category)
    {
        $query = "INSERT INTO categories (title, avatar, description) VALUES (:title, :avatar, :description)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':title', $category->title);
        $stmt->bindParam(':avatar', $category->avatar);
        $stmt->bindParam(':description', $category->description);

        if ($stmt->execute()) {
            $category->id = $this->_db->lastInsertId();
            return $category;
        }
        return null;
    }

    public function getCategoryById($id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getCategoryByTitle($title)
    {
        $query = "SELECT * FROM categories WHERE title = :title";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateCategory($id, Category $category)
    {
        $query = "UPDATE categories SET title = :title, avatar = :avatar, description = :description, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $category->title);
        $stmt->bindParam(':avatar', $category->avatar);
        $stmt->bindParam(':description', $category->description);
        $stmt->bindParam(':updated_at', $category->updated_at);
        return $stmt->execute();
    }

    public function deleteCategoryById($id)
    {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
