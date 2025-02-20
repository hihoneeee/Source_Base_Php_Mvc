<?php

namespace App\core;

use App\Helpers\UrlAction;

class Controller
{
    protected $UrlAction;
    protected $contentForLogin = null;

    public function __construct()
    {
        $this->UrlAction = new UrlAction();
    }
    protected function render($area = null, $view, $data = [])
    {
        extract($data);

        // Điều chỉnh đường dẫn theo khu vực (Admin hoặc Public)
        $viewPath = $area ? "./App/Views/{$area}/{$view}.php" : "./App/Views/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$viewPath}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $area === 'Admin' ? "./App/Views/Admin/Layout.php" : "./App/Views/Public/Layout.php";
    }



    protected function redirectToAction($area, $controller = '', $action = 'index', $id = null)
    {
        // Lấy base URL từ server
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

        // Xây dựng URL tuyệt đối
        if ($area === 'public') {
            $url = $action === 'index'
                ? "$baseUrl/$controller"
                : "$baseUrl/$controller/$action";
        } elseif ($area === 'admin') {
            $url = $action === 'index'
                ? ($controller ? "$baseUrl/admin/$controller" : "$baseUrl/admin")
                : "$baseUrl/admin/$controller/$action";
        }

        if ($id !== null) {
            $url .= "/$id";
        }

        // Redirect
        header("Location: $url");
        exit;
    }

    protected function renderForLoginAdmin($view, $data = [])
    {
        extract($data);
        $UrlAction = $this->UrlAction;

        // Start output buffering
        ob_start();
        require "./App/Views/Admin/{$view}.php";
        $this->contentForLogin = ob_get_clean(); // Get the view content

        // Sửa lại đường dẫn tới file layout
        require "./App/Views/Admin/AuthenticationLayout.php";
    }
}
