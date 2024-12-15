<?php

namespace App\DTOs\Post;

use App\DTOs\Common\PaginationDTO;

class SearchCondition extends PaginationDTO
{
    public $title;
    public $userId;
    public $categoryId;
    public $time;

    public function __construct($title, $userId, $categoryId, $time)
    {
        $this->title = $title;
        $this->userId = $userId;
        $this->categoryId = $categoryId;
        $this->time = $time;
    }
}