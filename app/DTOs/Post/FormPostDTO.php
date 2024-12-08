<?php

namespace App\DTOs\Post;

class FormPostDTO
{
    public $user_id;
    public $category_id;
    public $status;
    public $updated_at;
    public $errors = [];

    public function __construct($user_id, $category_id, $status)
    {
        $this->user_id = $user_id;
        $this->category_id = $category_id;
        $this->status = $status;
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function isValid($isUpdate = false)
    {
        $this->errors = [];

        if (empty($this->user_id)) {
            $this->errors['user_id'] = 'Người viết không được bỏ trống';
        }

        if (empty($this->category_id)) {
            $this->errors['category_id'] = 'Danh mục bài viểt không được bỏ trống';
        }

        return empty($this->errors);
    }
}
