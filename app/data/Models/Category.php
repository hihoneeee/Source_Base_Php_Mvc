<?php

namespace App\Data\Models;

class Category
{
    public $id;
    public $title;
    public $avatar;
    public $description;
    public $created_at;
    public $updated_at;

    public function __construct($data = [])
    {
        $this->title = $data['title'] ?? throw new \InvalidArgumentException("Title is required");
        $this->avatar = $data['avatar'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
