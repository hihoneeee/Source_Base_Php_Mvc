<?php

namespace App\DTOs\Comment;

class GetCommentDTO
{
    public $id;
    public $user_id;
    public $postDetail_id;
    public $content;
    public $created_at;
    public $updated_at;
    public $dataUser = [];
}