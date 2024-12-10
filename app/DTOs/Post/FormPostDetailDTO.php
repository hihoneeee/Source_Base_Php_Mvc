<?php

namespace App\DTOs\Post;

class FormPostDetailDTO
{
    public $title;
    public $meta;
    public $content;
    public $avatar;
    public $errors = [];

    public function __construct($title, $meta, $content, $avatar)
    {
        $this->title = $title;
        $this->meta = $meta;
        $this->content = $content;
        $this->avatar = $avatar;
    }

    public function isValid()
    {
        $this->errors = [];

        if (empty($this->title)) {
            $this->errors['title'] = 'Tiêu đề không được bỏ trống';
        } elseif (strlen($this->title) < 5) {
            $this->errors['title'] = 'Tiêu đề phải có ít nhất 3 ký tự!';
        }

        if (empty($this->meta)) {
            $this->errors['meta'] = 'Mô tả không được bỏ trống';
        } elseif (strlen($this->meta) < 150) {
            $this->errors['meta'] = 'Mô tả phải có ít nhất 130 ký tự!';
        }

        if (empty($this->content)) {
            $this->errors['content'] = 'Nội dung không được bỏ trống';
        }

        if ($this->avatar && $this->avatar['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileName = $this->avatar['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                $this->errors['avatar'] = 'Avatar phải là định dạng jpg, jpeg, png hoặc gif!';
            }

            if ($this->avatar['size'] > 2 * 1024 * 1024) { // 2MB
                $this->errors['avatar'] = 'Avatar không được vượt quá 2MB!';
            }
        }

        return empty($this->errors);
    }
}
