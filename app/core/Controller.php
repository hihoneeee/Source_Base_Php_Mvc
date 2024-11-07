<?php
require_once './app/Helpers/UrlAction.php';

class Controller {
    // protected $UrlAction;

    // public function __construct() {
    //     $this->UrlAction = new UrlAction();
    // }
    protected function render($view, $data = []) {
        extract($data);
        // $UrlAction = $this->UrlAction;

        // Start output buffering
        ob_start();
        require "./app/views/{$view}.php";
        $content = ob_get_clean(); // Get the view content as $content
    
        // Pass $content to layout.php
        require "./app/views/layout.php";
    }

    protected function redirectToAction($controller, $action = 'index') {
        $baseUrl = BASE_URL; // Đảm bảo BASE_URL được định nghĩa trong config
    
        // Nếu action là 'index', bỏ qua action khỏi URL
        $url = $action === 'index' ? "{$baseUrl}/{$controller}" : "{$baseUrl}/{$controller}/{$action}";
    
        header("Location: $url");
        exit; // Dừng xử lý sau khi redirect
    }
    
    
}