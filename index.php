<?php
// đăng ký tệp hệ thống
require_once './config/config.php';
require_once './app/core/Controller.php';
require_once './app/core/Router.php';

// đăng ký Repo và services
require_once './app/repositories/UserRepository.php';
require_once './app/services/UserService.php';

//đăng ký controller
require_once './app/controllers/UserController.php';
require_once './app/controllers/HomeController.php';

session_start();
ob_start();

// Khởi tạo kết nối DB
$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Khởi tạo Repository và Service
$userRepository = new UserRepository($db);
$userService = new UserService($userRepository);


// Khởi tạo Router với DB connection
$router = new Router();

// Load các file router và truyền router vào
require_once './app/routers/Home.php';
require_once './app/routers/User.php';

// Lấy URL từ query string và dispatch route
$url = isset($_GET['url']) ? $_GET['url'] : '';
$router->dispatch($url);