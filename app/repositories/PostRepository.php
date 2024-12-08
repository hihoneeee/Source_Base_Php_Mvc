<?php

namespace App\Repositories;

use App\Data\Models\Post;
use PDO;

class PostRepository
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }
    public function getAllPostsByAdmin($limit, $page, $name)
    {
        $offset = ($page - 1) * $limit;
        $query = "
                SELECT 
                    p.*, 
                    CONCAT(u.first_name, ' ', u.last_name) AS fullName,
                    pd.title, pd.meta, pd.avatar,
                    c.value AS categoryName
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN postDetail pd ON p.id = pd.post_id
                JOIN category c ON p.category_id = c.id
            ";
        if (!empty($name)) {
            $query .= " WHERE pd.title LIKE :name OR u.first_name LIKE :name OR u.last_name LIKE :name OR c.value LIKE :name";
        }
        $query .= " ORDER BY p.updated_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->_db->prepare($query);
        if (!empty($name)) {
            $nameParam = '%' . $name . '%';
            $stmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $totalQuery = "SELECT COUNT(*) AS total 
                       FROM posts p 
                       JOIN postDetail pd ON p.id = pd.post_id
                       JOIN users u ON p.user_id = u.id
                       JOIN category c ON p.category_id = c.id ";
        if (!empty($name)) {
            $query .= " WHERE pd.title LIKE :name OR u.first_name LIKE :name OR u.last_name LIKE :name OR c.value LIKE :name";
        }
        $totalStmt = $this->_db->prepare($totalQuery);
        if (!empty($name)) {
            $totalStmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['posts' => $posts, 'total' => $total];
    }

    public function getPostsByUser($id, $limit, $page, $name = null)
    {
        $offset = ($page - 1) * $limit;
        $query = "
                SELECT 
                    p.*, 
                    CONCAT(u.first_name, ' ', u.last_name) AS fullName,
                    pd.title, pd.meta, pd.avatar,
                    c.value AS categoryName
                FROM posts p
                JOIN users u ON p.user_id = u.id
                JOIN postDetail pd ON p.id = pd.post_id
                JOIN category c ON p.category_id = c.id
                WHERE p.user_id = :id
            ";
        if (!empty($name)) {
            $query .= " WHERE pd.title LIKE :name OR u.first_name LIKE :name OR u.last_name LIKE :name OR c.value LIKE :name";
        }
        $query .= " ORDER BY p.updated_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if (!empty($name)) {
            $nameParam = '%' . $name . '%';
            $stmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $totalQuery = "SELECT COUNT(*) AS total 
                   FROM posts p 
                   JOIN postDetail pd ON p.id = pd.post_id
                   JOIN users u ON p.user_id = u.id
                   JOIN category c ON p.category_id = c.id 
                   WHERE p.user_id = :id";
        if (!empty($name)) {
            $query .= " WHERE pd.title LIKE :name OR u.first_name LIKE :name OR u.last_name LIKE :name OR c.value LIKE :name";
        }
        $totalStmt = $this->_db->prepare($totalQuery);
        $totalStmt->bindParam(':id', $id, PDO::PARAM_INT);
        if (!empty($name)) {
            $totalStmt->bindValue(':name', $nameParam, PDO::PARAM_STR);
        }
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['posts' => $posts, 'total' => $total];
    }

    public function getListPost()
    {
        $query = "SELECT * FROM posts";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function createPost(Post $post)
    {
        $query = "INSERT INTO posts (user_id, category_id, status) VALUES (:user_id, :category_id, :status)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':user_id', $post->user_id);
        $stmt->bindParam(':category_id', $post->category_id);
        $stmt->bindParam(':status', $post->status);

        if ($stmt->execute()) {
            $post->id = $this->_db->lastInsertId();
            return $post;
        }
        return null;
    }

    public function getPostById($id)
    {
        $query = "
            SELECT 
                posts.*, 
                postDetail.id AS postDetailId, 
                postDetail.title, 
                postDetail.meta, 
                postDetail.content, 
                postDetail.avatar 
            FROM posts
            LEFT JOIN postDetail ON posts.id = postDetail.post_id
            WHERE posts.id = :id
        ";

        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updatePost($id, Post $post)
    {
        $query = "UPDATE posts SET user_id = :user_id, category_id = :category_id, status = :status, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $post->user_id);
        $stmt->bindParam(':category_id', $post->category_id);
        $stmt->bindParam(':status', $post->status);
        $stmt->bindParam(':updated_at', $post->updated_at);
        return $stmt->execute();
    }

    public function deletePostById($id)
    {
        $query = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
