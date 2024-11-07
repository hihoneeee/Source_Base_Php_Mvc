<?php

class CreateRoleHasPermissionsTable {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $sql = "CREATE TABLE roleHasPermissions (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    role_id INT,
                    permission_id INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'roleHasPermissions' created successfully.\n";
        } else {
            echo "Error creating table 'roleHasPermissions': " . $this->db->error . "\n";
        }
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS roleHasPermissions";

        if ($this->db->query($sql)) {
            echo "Table 'roleHasPermissions' dropped successfully.\n";
        } else {
            echo "Error dropping table 'roleHasPermissions': " . $this->db->error . "\n";
        }
    }
}