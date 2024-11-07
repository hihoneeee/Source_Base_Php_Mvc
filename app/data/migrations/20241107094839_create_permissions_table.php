<?php

class CreatePermissionsTable {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $sql = "CREATE TABLE permissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            value VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if ($this->db->query($sql)) {
            echo "Table 'permissions' created successfully.\n";
        } else {
            echo "Error creating table 'permissions': " . $this->db->error . "\n";
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS permissions";

        if ($this->db->query($sql)) {
            echo "Table 'permissions' dropped successfully.\n";
        } else {
            echo "Error dropping table 'permissions': " . $this->db->error . "\n";
        }
    }
}