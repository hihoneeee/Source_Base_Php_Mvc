<?php

class Migration {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Thực hiện câu lệnh SQL
    public function execute($sql) {
        if ($this->db->query($sql) === TRUE) {
            echo "Migration executed successfully.\n";
        } else {
            echo "Error executing migration: " . $this->db->error . "\n";
        }
    }

    // Kiểm tra xem bảng migrations đã tồn tại chưa, nếu chưa thì tạo bảng
    public function createMigrationTable() {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->execute($sql);
    }

    // Kiểm tra xem migration đã được chạy chưa
    public function migrationExists($migration) {
        $sql = "SELECT * FROM migrations WHERE migration = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $migration);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Ghi lại migration đã được chạy
    public function logMigration($migration) {
        $sql = "INSERT INTO migrations (migration) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $migration);
        $stmt->execute();
    }
}