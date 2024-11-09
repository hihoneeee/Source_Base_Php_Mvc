<?php
// đăng ký tệp hệ thống
require_once './config/config.php';
require_once './app/core/Controller.php';
require_once './app/core/Router.php';

// đăng ký Repo và services
require_once './app/repositories/UserRepository.php';
require_once './app/services/UserService.php';

require_once './app/services/RoleService.php';
require_once './app/repositories/RoleRepository.php';

//đăng ký controller
require_once './app/controllers/UserController.php';
require_once './app/controllers/HomeController.php';
require_once './app/controllers/RoleController.php';

require_once './app/DTOs/Role/CreateRoleDTO.php';
session_start();
ob_start();

// Khởi tạo kết nối DB
$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Khởi tạo Repository và Service
$userRepository = new UserRepository($db);
$userService = new UserService($userRepository);

$roleRepository = new RoleRepository($db);
$roleService = new RoleService($roleRepository);

// Register Controllers with their respective services
$userController = new UserController($userService);
$roleController = new RoleController($roleService);

// Initialize Router
$router = new Router([
    'UserController' => $userController,
    'RoleController' => $roleController,
]);

// Load router files
require_once './app/routers/Home.php';
require_once './app/routers/User.php';
require_once './app/routers/Role.php';

// Get URL from query string and dispatch route
$url = isset($_GET['url']) ? $_GET['url'] : '';
$router->dispatch($url);