<?php

class Controller {

    protected function render($view, $data = []) {
        extract($data);
        
        // Start output buffering
        ob_start();
        require "./app/views/{$view}.php";
        $content = ob_get_clean(); // Get the view content as $content
    
        // Pass $content to layout.php
        require "./app/views/layout.php";
    }

    protected function redirectToAction($controller, $action) {
        // Chuyển hướng đến action trong controller được chỉ định
        header("Location: /{$controller}/{$action}");
        exit; // Dừng xử lý sau khi redirect
    }
}