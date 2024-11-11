<?php

class CreateRoleDTO {
    public $value;
    public $errors = [];

    public function __construct($value) {
        $this->value = $value;
    }

    public function isValid() {
        $this->errors = []; // Reset errors

        if (empty($this->value)) {
            $this->errors['value'] = 'Value is required';
        } elseif (strlen($this->value) < 3) {
            $this->errors['value'] = 'Value must be at least 3 characters';
        }

        return empty($this->errors); // Return true if there are no errors
    }
}