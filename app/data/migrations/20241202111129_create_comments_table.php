<?php

class CreateCommentsTable
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $sql = "CREATE TABLE comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            postDetail_id INT NOT NULL,
            user_id INT NOT NULL,
            content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT comments_fk_postDetail FOREIGN KEY (postDetail_id) REFERENCES postDetail(id) ON DELETE CASCADE,
            CONSTRAINT comments_fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=INNODB";


        if ($this->db->query($sql)) {
            echo "Table 'comments' created successfully.\n";
        } else {
            echo "Error creating table 'comments': " . $this->db->error . "\n";
        }
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS comments";

        if ($this->db->query($sql)) {
            echo "Table 'comments' dropped successfully.\n";
        } else {
            echo "Error dropping table 'comments': " . $this->db->error . "\n";
        }
    }
}
