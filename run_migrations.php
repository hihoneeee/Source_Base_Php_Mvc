<?php

require_once './config/config.php';
require_once './app/data/Migration.php';

$rollback = in_array('--rollback', $argv);
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
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

if ($rollback) {
    $sql = "DROP TABLE IF EXISTS migrations";
    if ($db->query($sql)) {
        echo "Bảng migrations đã được xóa.\n";
    } else {
        echo "Lỗi khi xóa bảng migrations: " . $db->error;
    }
}

$db->close();