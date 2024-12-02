<?php

namespace App\Data\Models;

class PostDetailStatus
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

class PostDetail
{
    public $id;
    public $content;
    public $post_id;
    public $avatar;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->status = PostDetailStatus::STATUS_PENDING;
    }

    /**
     * Gán giá trị cho status.
     */
    public function setStatus($status)
    {
        if (!PostDetailStatus::isValidStatus($status)) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }

        $this->status = $status;
    }
}
