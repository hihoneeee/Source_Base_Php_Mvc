<?php

namespace App\DTOs\Category;

class GetCategoryDTO
{
    public $title;
    public $description;
    public $avatar;
    public $created_at;
    public $updated_at;
    public $dataPost = [];
}