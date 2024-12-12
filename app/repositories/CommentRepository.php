<?php

namespace App\Repositories;

use App\Data\Models\Comment;
use PDO;

class CommentRepository
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }
    public function getListCommentsByPostId($id, $limit, $page)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT c.*,
                        CONCAT(u.first_name, ' ', u.last_name) AS fullName,
                        u.avatar
                  FROM comments c
                  JOIN users u ON c.user_id = u.id
                  WHERE c.postDetail_id	 = :id
                  ORDER BY c.updated_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);

        $totalQuery = "SELECT COUNT(c.id) AS total FROM comments c WHERE c.postDetail_id = :id";
        $totalStmt = $this->_db->prepare($totalQuery);
        $totalStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        return ['comments' => $comments, 'total' => $total];
    }

    public function createComment(Comment $comment)
    {
        $query = "INSERT INTO comments (content, postDetail_id, user_id, created_at, updated_at) VALUES (:content, :postDetail_id, :user_id, :created_at, :updated_at)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':content', $comment->content);
        $stmt->bindParam(':postDetail_id', $comment->postDetail_id);
        $stmt->bindParam(':user_id', $comment->user_id);
        $stmt->bindParam(':created_at', $comment->created_at);
        $stmt->bindParam(':updated_at', $comment->updated_at);
        if ($stmt->execute()) {
            $comment->id = $this->_db->lastInsertId();
            return $comment;
        }
        return null;
    }

    public function getCommentById($id)
    {
        $query = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateComment($id, Comment $comment)
    {
        $query = "UPDATE comments SET content = :content, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':content', $comment->content);
        $stmt->bindParam(':updated_at', $comment->updated_at);
        return $stmt->execute();
    }

    public function deleteCommentById($id)
    {
        $query = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
