<?php

class CreatePostsTable
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $sql = "CREATE TABLE posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            category_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT post_fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            CONSTRAINT post_fk_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'posts' created successfully.\n";
        } else {
            echo "Error creating table 'posts': " . $this->db->error . "\n";
        }
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS posts";

        if ($this->db->query($sql)) {
            echo "Table 'posts' dropped successfully.\n";
        } else {
            echo "Error dropping table 'posts': " . $this->db->error . "\n";
        }
    }
}