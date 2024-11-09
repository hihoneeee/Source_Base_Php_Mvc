<?php
class CreateUsersTable {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(15),
            avatar VARCHAR(255),
            password VARCHAR(255) NOT NULL,
            role_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'users' created successfully.\n";
        } else {
            echo "Error creating table 'users': " . $this->db->error . "\n";
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS users";

        if ($this->db->query($sql)) {
            echo "Table 'users' dropped successfully.\n";
        } else {
            echo "Error dropping table 'users': " . $this->db->error . "\n";
        }
    }
}