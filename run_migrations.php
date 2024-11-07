<?php

require_once './config/config.php';
require_once './app/data/Migration.php';

// Get the rollback flag from the command line (e.g., php run_migrations.php --rollback)
$rollback = in_array('--rollback', $argv);

// Kết nối tới cơ sở dữ liệu
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$migrationManager = new Migration($db);
$migrationManager->createMigrationTable();

$migrationFiles = glob('app/data/migrations/*.php');

foreach ($migrationFiles as $file) {
    $migrationName = basename($file, '.php');

    // Bao gồm file migration
    require_once $file;

    // Tạo tên class từ tên file (chuyển đổi sang CamelCase)
    $className = str_replace(' ', '', ucwords(str_replace('_', ' ', str_replace('2024_10_17_', '', $migrationName))));

    // Khởi tạo đối tượng migration
    $migrationInstance = new $className($db);

    if ($rollback) {
        // Thực thi phương thức down() để rollback migration (xóa bảng)
        $migrationInstance->down();
    } else {
        // Thực thi phương thức up() để chạy migration (tạo bảng)
        $migrationInstance->up();
        $migrationManager->logMigration($migrationName);
    }
}

// If rolling back, also drop the 'migrations' table
if ($rollback) {
    $sql = "DROP TABLE IF EXISTS migrations";
    if ($db->query($sql)) {
        echo "Bảng migrations đã được xóa.\n";
    } else {
        echo "Lỗi khi xóa bảng migrations: " . $db->error;
    }
}

$db->close();