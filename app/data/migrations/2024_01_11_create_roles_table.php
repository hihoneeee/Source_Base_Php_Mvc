<?php

class CreateRolesTable {
    public function up() {
        // Viết câu lệnh SQL để tạo bảng users
        $sql = "CREATE TABLE roles (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(45) NOT NULL UNIQUE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->query($sql)) {
            echo "Roles executed successfully!";
        } else {
            echo "Lỗi: " . $db->error;
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS users";
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->query($sql)) {
            echo "Bảng roles đã được xóa.";
        } else {
            echo "Lỗi: " . $db->error;
        }
    }
}