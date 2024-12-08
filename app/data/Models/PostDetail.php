<?php

namespace App\Data\Models;

class PostDetail
{
    public $id;
    public $title;
    public $meta;
    public $content;
    public $post_id;
    public $avatar;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

}