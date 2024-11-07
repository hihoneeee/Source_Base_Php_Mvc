<?php
class CreateRolesTable {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $sql = "CREATE TABLE roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            value VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'roles' created successfully.\n";
        } else {
            echo "Error creating table 'roles': " . $this->db->error . "\n";
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS roles";

        if ($this->db->query($sql)) {
            echo "Table 'roles' dropped successfully.\n";
        } else {
            echo "Error dropping table 'roles': " . $this->db->error . "\n";
        }
    }
}