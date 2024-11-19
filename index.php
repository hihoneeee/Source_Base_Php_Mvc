<?php

// Nếu file tồn tại (tĩnh như CSS, JS, hình ảnh), trả về trực tiếp
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    return false;
}

require_once './vendor/autoload.php';
require_once './Config/Config.php';

use App\Core;
use App\Repositories;
use App\Services;
use App\Controllers;
use App\Routers;


// Khởi tạo session và buffer
session_start();
ob_start();

// Khởi tạo kết nối DB
$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Khởi tạo Mapper
$mapper = new Core\Mapper();

// Khởi tạo Repository và Service
$userRepository = new Repositories\UserRepository($db);
$userService = new Services\UserService($userRepository, $mapper);

$roleRepository = new Repositories\RoleRepository($db);
$roleService = new Services\RoleService($roleRepository, $mapper);

// Khởi tạo Controller với Service tương ứng
$userController = new Controllers\UserController($userService, $roleRepository);
$roleController = new Controllers\RoleController($roleService);
$homeController = new Controllers\HomeController($roleService, $userService);

// Khởi tạo Router và đăng ký Controller
$router = new Core\Router([
    'UserController' => $userController,
    'RoleController' => $roleController,
    'HomeController' => $homeController,
]);

// Đăng ký các route
Routers\HomeRouter::register($router);
Routers\UserRouter::register($router);
Routers\RoleRouter::register($router);

// Lấy URL và xử lý routing
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = ltrim($url, '/');
$router->dispatch($url);
