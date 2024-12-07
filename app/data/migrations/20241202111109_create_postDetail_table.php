<?php

class CreatePostDetailTable
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $sql = "CREATE TABLE postDetail (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content TEXT NOT NULL,
            post_id INT NOT NULL,
            avatar VARCHAR(255),
            status ENUM('pending', 'completed', 'hidden') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT postDetail_fk_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'postDetail' created successfully.\n";
        } else {
            echo "Error creating table 'postDetail': " . $this->db->error . "\n";
        }
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS postDetail";

        if ($this->db->query($sql)) {
            echo "Table 'postDetail' dropped successfully.\n";
        } else {
            echo "Error dropping table 'postDetail': " . $this->db->error . "\n";
        }
    }
}