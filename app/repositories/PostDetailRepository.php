<?php

namespace App\Repositories;

use App\Data\Models\PostDetail;
use PDO;

class PostDetailRepository
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function createPostDetail(PostDetail $postDetail)
    {
        $query = "INSERT INTO postdetail (title, meta, content, post_id, avatar, status) VALUES (:title, :meta, :content, :post_id, :avatar, :status)";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':content', $postDetail->content);
        $stmt->bindParam(':post_id', $postDetail->post_id);
        $stmt->bindParam(':avatar', $postDetail->avatar);
        if ($stmt->execute()) {
            $postDetail->id = $this->_db->lastInsertId();
            return $postDetail;
        }
        return null;
    }

    public function getPostDetailById($id)
    {
        $query = "SELECT * FROM postdetail WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updatePostDetail($id, PostDetail $postDetail)
    {
        $query = "UPDATE postdetail SET title = :title, meta = :meta, content = :content, avatar = :avatar, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $postDetail->title);
        $stmt->bindParam(':meta', $postDetail->meta);
        $stmt->bindParam(':content', $postDetail->content);
        $stmt->bindParam(':avatar', $postDetail->avatar);
        $stmt->bindParam(':updated_at', $postDetail->updated_at);
        return $stmt->execute();
    }

    public function deletePostDetailById($id)
    {
        $query = "DELETE FROM postdetail WHERE id = :id";
        $stmt = $this->_db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}