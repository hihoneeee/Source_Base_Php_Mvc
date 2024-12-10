<?php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected $controllers = [];

    public function __construct($controllers)
    {
        $this->controllers = $controllers;
    }

    // Add route with controller, action, and optional roles
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    // Dispatch method
    public function dispatch($url)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Khởi tạo session nếu chưa có
        }

        foreach ($this->routes as $route => $params) {
            $routePattern = preg_replace('/\{id\}/', '(\d+)', $route);

            if (preg_match("#^$routePattern$#", $url, $matches)) {
                if (isset($params['roles']) && !$this->isAuthorized($params['roles'])) {
                    $_SESSION['toastMessage'] = "Bạn không có quyền truy cập vào trang này!";
                    session_write_close();
                    header('Location: /admin');
                    exit;
                }
                $controllerName = $params['controller'];
                $actionName = $params['action'];
                $id = $matches[1] ?? null;

                if (isset($this->controllers[$controllerName]) && method_exists($this->controllers[$controllerName], $actionName)) {
                    $controller = $this->controllers[$controllerName];
                    $id ? $controller->$actionName($id) : $controller->$actionName();
                    return;
                } else {
                    echo "Controller or action does not exist.";
                    return;
                }
            }
        }
        echo "404 - Route not found";
    }


    // Check if user has required role
    private function isAuthorized($allowedRoles)
    {
        if (isset($_SESSION['user_info']) && isset($_SESSION['user_info']->role)) {
            $userRole = $_SESSION['user_info']->role;
            return in_array($userRole, $allowedRoles); // Kiểm tra role có trong danh sách cho phép không
        }
        return false; // Không có thông tin hoặc không đủ quyền
    }
}
