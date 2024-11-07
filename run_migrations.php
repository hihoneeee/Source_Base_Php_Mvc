<?php

require_once './config/config.php';
require_once './app/data/Migration.php';

// Nhận lệnh từ dòng lệnh (ví dụ: php run_migrations.php --rollback hoặc --drop-database)
$rollback = in_array('--rollback', $argv);
$dropDatabase = in_array('--drop-database', $argv);

// Kết nối tới cơ sở dữ liệu
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($dropDatabase) {
    // Xóa tất cả các bảng trong cơ sở dữ liệu
    $db->query("SET FOREIGN_KEY_CHECKS = 0"); // Tắt kiểm tra khóa ngoại để có thể xóa bảng liên kết

    $tablesResult = $db->query("SHOW TABLES");
    while ($table = $tablesResult->fetch_array()) {
        $tableName = $table[0];
        $db->query("DROP TABLE IF EXISTS $tableName");
        echo "Bảng $tableName đã được xóa.\n";
    }

    $db->query("SET FOREIGN_KEY_CHECKS = 1"); // Bật lại kiểm tra khóa ngoại
    echo "Tất cả các bảng trong cơ sở dữ liệu đã được xóa.\n";

    $db->close();
    exit; // Dừng xử lý sau khi xóa database
}

$migrationManager = new Migration($db);
$migrationManager->createMigrationTable();

$migrationFiles = glob('app/data/migrations/*.php');

foreach ($migrationFiles as $file) {
    $migrationName = basename($file, '.php');

    // Include the migration file
    require_once $file;

    // Convert filename to class name (remove date prefix and convert to CamelCase)
    $className = preg_replace('/^\d+_/', '', $migrationName); // Remove date prefix
    $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $className)));

    // Check if class exists and instantiate it
    if (class_exists($className)) {
        $migrationInstance = new $className($db);

        if ($rollback) {
            $migrationInstance->down();
        } else {
            $migrationInstance->up();
            $migrationManager->logMigration($migrationName);
        }
    } else {
        echo "Class \"$className\" not found for migration file \"$migrationName\".\n";
    }
}

// Xóa bảng migrations nếu rollback
if ($rollback) {
    $sql = "DROP TABLE IF EXISTS migrations";
    if ($db->query($sql)) {
        echo "Bảng migrations đã được xóa.\n";
    } else {
        echo "Lỗi khi xóa bảng migrations: " . $db->error;
    }
}

$db->close();