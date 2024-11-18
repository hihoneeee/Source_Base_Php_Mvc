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
require_once './app/DTOs/User/CreateUserDTO.php';

require_once './app/core/Mapper.php';

session_start();
ob_start();

// Khởi tạo kết nối DB
$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mapper = new Mapper();

// Khởi tạo Repository và Service
$userRepository = new UserRepository($db);
$userService = new UserService($userRepository, $mapper);

$roleRepository = new RoleRepository($db);
$roleService = new RoleService($roleRepository, $mapper);

// Register Controllers with their respective services
$userController = new UserController($userService, $roleRepository);
$roleController = new RoleController($roleService);
$homeController = new HomeController($roleService, $userService);

// Initialize Router
$router = new Router([
    'UserController' => $userController,
    'RoleController' => $roleController,
    'HomeController' => $homeController,
]);

// Load router files
require_once './app/routers/Home.php';
require_once './app/routers/User.php';
require_once './app/routers/Role.php';

// Get URL from query string and dispatch route
$url = isset($_GET['url']) ? $_GET['url'] : '';
$router->dispatch($url);
