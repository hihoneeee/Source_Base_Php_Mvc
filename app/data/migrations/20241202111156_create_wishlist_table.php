<?php

class CreateWishlistTable
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $sql = "CREATE TABLE wishlist (
            id INT AUTO_INCREMENT PRIMARY KEY,
            postDetail_id INT NOT NULL,
            user_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT wishlist_fk_postDetail FOREIGN KEY (postDetail_id) REFERENCES postDetail(id) ON DELETE CASCADE,
            CONSTRAINT wishlist_fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=INNODB";

        if ($this->db->query($sql)) {
            echo "Table 'wishlist' created successfully.\n";
        } else {
            echo "Error creating table 'wishlist': " . $this->db->error . "\n";
        }
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS wishlist";

        if ($this->db->query($sql)) {
            echo "Table 'wishlist' dropped successfully.\n";
        } else {
            echo "Error dropping table 'wishlist': " . $this->db->error . "\n";
        }
    }
}
