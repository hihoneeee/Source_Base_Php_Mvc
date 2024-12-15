<?php

namespace App\Repositories;

use App\Data\Models\Category;
use Exception;
use PDO;
use PDOException;

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
        $query = "
            SELECT 
                c.id, 
                c.title, 
                COUNT(p.id) AS postCount
            FROM categories c
            LEFT JOIN posts p ON c.id = p.category_id AND p.status = 'completed'
            GROUP BY c.id, c.title";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        $query = "
            SELECT 
                c.id, 
                c.title
            FROM categories c
            GROUP BY c.id, c.title";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategoryDetailsById($categoryId, $limit, $page)
    {
        $offset = ($page - 1) * $limit;

        // Truy vấn thông tin danh mục
        $categoryQuery = "
            SELECT title
            FROM categories
            WHERE id = :categoryId;
        ";

        $categoryStmt = $this->_db->prepare($categoryQuery);
        $categoryStmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);

        try {
            $categoryStmt->execute();
            $category = $categoryStmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception('SQL Execution Error: ' . $e->getMessage());
        }

        if (!$category) {
            throw new Exception('Category not found.');
        }

        // Truy vấn bài viết trong danh mục
        $postsQuery = "
                SELECT
                    p.id,
                    CONCAT(u.first_name, ' ', u.last_name) AS fullName,
                    pd.title AS postTitle, 
                    pd.meta, 
                    pd.avatar, 
                    p.updated_at
                FROM posts p
                LEFT JOIN postdetail pd ON p.id = pd.post_id
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.category_id = :categoryId
                AND p.status = 'completed'
                ORDER BY p.updated_at DESC
                LIMIT :limit OFFSET :offset;
            ";
        $postsStmt = $this->_db->prepare($postsQuery);
        $postsStmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $postsStmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $postsStmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        try {
            $postsStmt->execute();
            $posts = $postsStmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception('SQL Execution Error: ' . $e->getMessage());
        }

        // Truy vấn tổng số bài viết
        $countQuery = "
            SELECT COUNT(*) AS total
            FROM posts
            WHERE category_id = :categoryId;
        ";

        $countStmt = $this->_db->prepare($countQuery);
        $countStmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);

        try {
            $countStmt->execute();
            $total = $countStmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception('SQL Execution Error: ' . $e->getMessage());
        }

        return [
            'category' => $category,
            'posts' => $posts,
            'total' => $total
        ];
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
