<?php

namespace App\Data\Models;

class Comment
{
    public $id;
    public $user_id;
    public $postDetail_id;
    public $content;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
