<?php

namespace App\Data\Models;

class PostStatus
{
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_HIDDEN = 'hidden';

    public static $validStatuses = [
        self::STATUS_PENDING,
        self::STATUS_COMPLETED,
        self::STATUS_HIDDEN,
    ];

    /**
     * Kiểm tra nếu giá trị status là hợp lệ.
     */
    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::$validStatuses, true);
    }
}

class Post
{
    public $id;
    public $content;
    public $user_id;
    public $category_id;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->status = PostStatus::STATUS_PENDING;
    }
}
