<?php

namespace App\Data\Models;

class Role
{
    public $id;
    public $value;
    public $created_at;
    public $updated_at;

    public function __construct($data = [])
    {
        $this->value = $data['value'] ?? null;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
