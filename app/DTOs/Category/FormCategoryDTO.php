<?php

namespace App\DTOs\Category;

class FormCategoryDTO
{
    public $title;
    public $description;
    public $avatar;
    public $updated_at;
    public $errors = [];

    public function __construct($title, $description, $avatar)
    {
        $this->title = $title;
        $this->description = $description;
        $this->avatar = $avatar;
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function isValid($isUpdate = false)
    {
        $this->errors = [];

        if (empty($this->title)) {
            $this->errors['title'] = 'Tên danh mục không được bỏ trống';
        } elseif (strlen($this->title) < 5) {
            $this->errors['title'] = 'Tên danh mục phải có ít nhất 3 ký tự!';
        }

        if (empty($this->description)) {
            $this->errors['description'] = 'Mô tả danh mục không được bỏ trống';
        } elseif (strlen($this->description) < 5) {
            $this->errors['description'] = 'Mô tả danh mục phải có ít nhất 3 ký tự!';
        }

        // Kiểm tra avatar (file phải là hình ảnh và không được vượt quá 2MB)
        if (!$isUpdate || ($this->avatar && $this->avatar['error'] === UPLOAD_ERR_OK)) {
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
