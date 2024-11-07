<?php

if ($argc < 2) {
    echo "Usage: php make_migration.php create_[table_name]_table\n";
    exit(1);
}

$action = $argv[1];
$datePrefix = date('YmdHis'); // Dấu thời gian hiện tại
$tableName = str_replace('create_', '', str_replace('_table', '', $action)); // Tên bảng từ lệnh

// Đặt tên file migration theo cú pháp Laravel
$fileName = "app/data/migrations/{$datePrefix}_{$action}.php";
$className = ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $action))));

// Nội dung cơ bản của file migration với các phương thức up và down
$migrationTemplate = <<<PHP
<?php

class {$className} {
    private \$db;

    public function __construct(\$db) {
        \$this->db = \$db;
    }

    public function up() {
        \$sql = "CREATE TABLE {$tableName} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            // Add your fields here
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (\$this->db->query(\$sql)) {
            echo "Table '{$tableName}' created successfully.\\n";
        } else {
            echo "Error creating table '{$tableName}': " . \$this->db->error . "\\n";
        }
    }

    public function down() {
        \$sql = "DROP TABLE IF EXISTS {$tableName}";

        if (\$this->db->query(\$sql)) {
            echo "Table '{$tableName}' dropped successfully.\\n";
        } else {
            echo "Error dropping table '{$tableName}': " . \$this->db->error . "\\n";
        }
    }
}

PHP;

// Kiểm tra và ghi file migration
if (file_put_contents($fileName, $migrationTemplate)) {
    echo "Migration created: {$fileName}\n";
} else {
    echo "Failed to create migration.\n";
}