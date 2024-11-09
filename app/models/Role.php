<?php

class Role {
    public $id;
    public $value;
    public $created_at;
    public $updated_at;

    public function __construct($id, $value, $created_at, $updated_at) {
        $this->id = $id;
        $this->value = $value;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}