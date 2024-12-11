<?php

namespace App\DTOs\Comment;

class FormCommentDTO
{
    public $user_id;
    public $postDetail_id;
    public $content;
    public $updated_at;
    public $errors = [];

    public function __construct($user_id, $postDetail_id, $content)
    {
        $this->user_id = $user_id;
        $this->postDetail_id = $postDetail_id;
        $this->content = $content;
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function isValid()
    {
        $this->errors = [];

        if (empty($this->content)) {
            $this->errors['content'] = 'Nội dung không được bỏ trống';
        }

        return empty($this->errors);
    }
}
