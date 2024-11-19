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
    protected function render($view, $data = [])
    {
        extract($data);
        $UrlAction = $this->UrlAction;

        // Start output buffering
        ob_start();
        require "./app/views/{$view}.php";
        $content = ob_get_clean(); // Get the view content as $content

        // Pass $content to layout.php
        require "./app/views/layout.php";
    }

    protected function redirectToAction($controller, $action = 'index')
    {
        $url = $action === 'index' ? "/$controller" : "/$controller/$action";
        header("Location: $url");
        exit;
    }

    protected function renderForLogin($view, $data = [])
    {
        extract($data);
        $UrlAction = $this->UrlAction;

        // Start output buffering
        ob_start();
        require "./app/views/{$view}.php";
        $this->contentForLogin = ob_get_clean(); // Get the view content

        // Sửa lại đường dẫn tới file layout
        require "./app/views/AuthenticationLayout.php";
    }
}
