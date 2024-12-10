<?php

namespace App\DTOs\Post;

class GetPostDTO
{
    public $user_id;
    public $category_id;
    public $status;
    public $updated_at;
    public $dataDetail = [];
    public $dataUser = [];
    public $dataCategory = [];
}