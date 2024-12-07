<?php

class CreateCategoriesTable
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $sql = "CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            avatar VARCHAR(255),
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'categories' created successfully.\n";
        } else {
            echo "Error creating table 'categories': " . $this->db->error . "\n";
        }
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS categories";

        if ($this->db->query($sql)) {
            echo "Table 'categories' dropped successfully.\n";
        } else {
            echo "Error dropping table 'categories': " . $this->db->error . "\n";
        }
    }
}