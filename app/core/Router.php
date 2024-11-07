<?php
class Router {
    protected $routes = [];

    // Thêm route với controller và action tương ứng
    public function add($route, $params) {
        $this->routes[$route] = $params;
    }

    // Phương thức dispatch, xác định route và gọi controller
    public function dispatch($url) {
        foreach ($this->routes as $route => $params) {
            // Xử lý các route có tham số id động
            $routePattern = preg_replace('/\{id\}/', '(\d+)', $route); // Chuyển {id} thành dãy số

            if (preg_match("#^$routePattern$#", $url, $matches)) {
                $controllerName = $params['controller'];
                $actionName = $params['action'];
                
                // Kiểm tra xem có `id` không
                $id = $matches[1] ?? null;

                if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
                    $controller = new $controllerName($GLOBALS['userService']);

                    // Gọi action có hoặc không có tham số $id
                    $id ? $controller->$actionName($id) : $controller->$actionName();
                    return;
                } else {
                    echo "Controller hoặc action không tồn tại";
                    return;
                }
            }
        }
        echo "404 - Route not found";
    }
}