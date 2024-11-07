<?php

class CreateUsersTable {
    public function up() {
        // Viết câu lệnh SQL để tạo bảng users
        $sql = "CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(45) NOT NULL UNIQUE,
                    first_name VARCHAR(255) NOT NULL,
                    last_name VARCHAR(255) NOT NULL,
                    password_input CHAR(100) NOT NULL,
                    password_check CHAR(100) NOT NULL,
                    email VARCHAR(45) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

        // Thực thi câu lệnh SQL
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->query($sql)) {
            echo "Users executed successfully!";
        } else {
            echo "Lỗi: " . $db->error;
        }
    }

    public function down() {
        // Câu lệnh để rollback (xóa bảng users)
        $sql = "DROP TABLE IF EXISTS users";
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->query($sql)) {
            echo "Bảng users đã được xóa.";
        } else {
            echo "Lỗi: " . $db->error;
        }
    }
}