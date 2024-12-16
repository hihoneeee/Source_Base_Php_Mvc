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
use App\Routers\Admin as RouterAdmin;
use App\Routers\Public as RouterPublic;

use App\Helpers\JwtToken;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\HandleMiddleware;
use App\Repositories\PostDetailRepository;

// Khởi tạo session và buffer
session_start();
ob_start();

// Khởi tạo kết nối DB
$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Khởi tạo Mapper
$mapper = new Core\Mapper();

// Cấu hình JWT

// Khởi tạo Repository và Service
$roleRepository = new Repositories\RoleRepository($db);
$roleService = new Services\RoleService($roleRepository, $mapper);

$userRepository = new Repositories\UserRepository($db);
$userService = new Services\UserService($userRepository, $roleRepository, $mapper);

$fakeDataRepository = new Repositories\FakeDataRepository($db);
$fakeDataService = new Services\FakeDataService($fakeDataRepository);

$categoryRepository = new Repositories\CategoryRepository($db);
$categoryService = new Services\CategoryService($categoryRepository, $mapper);

$postDetailRepository = new Repositories\PostDetailRepository($db);
$postDetailService = new Services\PostDetailService($postDetailRepository, $mapper);

$postRepository = new Repositories\PostRepository($db);
$postService = new Services\PostService($postRepository, $mapper, $categoryRepository, $postDetailService);

$commentRepository = new Repositories\CommentRepository($db);
$commentService = new Services\CommentService($commentRepository, $mapper, $postDetailRepository);

$sendMailService = new Services\SendMailService();

// Khởi tạo hepler
$jwtToken = new JwtToken(JWT_SECRET, $roleRepository, $userRepository);

$authService = new Services\AuthService($userRepository, $jwtToken);

// Khởi tạo Controller với Service tương ứng
$userController = new Controllers\UserController($userService, $roleService);
$roleController = new Controllers\RoleController($roleService);
$categoryController = new Controllers\CategoryController($categoryService);
$postController = new Controllers\PostController($postService, $categoryService, $userRepository);
$commentController = new Controllers\CommentController($commentService);
$reportController = new Controllers\ReportController($postService, $userService, $categoryService);

$adminController = new Controllers\AdminController($roleService, $userService);
$authController = new Controllers\AuthController($authService, $sendMailService);
$fakeDataController = new Controllers\FakeDataController($fakeDataService);
$publicController = new Controllers\PublicController($categoryService, $roleService, $postService, $authService, $userService, $commentService);

// Khởi tạo middleware
$authMiddleware = new AuthMiddleware();
$middleware = new HandleMiddleware($jwtToken);

$middleware->handle();
$authMiddleware->handle();

// Khởi tạo Router và đăng ký Controller
$router = new Core\Router([
    'UserController' => $userController,
    'RoleController' => $roleController,
    'CategoryController' => $categoryController,
    'PostController' => $postController,
    'CommentController' => $commentController,
    'ReportController' => $reportController,

    'AdminController' => $adminController,
    'AuthController' => $authController,
    'FakeDataController' => $fakeDataController,
    'PublicController' => $publicController
]);

// Đăng ký các route
RouterAdmin\UserRouter::register($router);
RouterAdmin\RoleRouter::register($router);
RouterAdmin\CategoryRouter::register($router);
RouterAdmin\PostRouter::register($router);
RouterPublic\CommentRouter::register($router);

RouterAdmin\ReportRouter::register($router);
RouterAdmin\AdminRouter::register($router);
RouterAdmin\AuthRouter::register($router);
RouterAdmin\FakerDataRouter::register($router);
RouterPublic\PublicRouter::register($router);

// Lấy URL và xử lý routing
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = ltrim($url, '/');
$router->dispatch($url);
