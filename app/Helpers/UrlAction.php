<?php

class UrlAction {
    public static function action($controller, $action = 'index', $params = []) {
        // Sử dụng BASE_URL làm tiền tố cho URL
        $url = BASE_URL . "/$controller";
        
        if ($action !== 'index') {
            $url .= "/$action";
        }

        if (!empty($params)) {
            $url .= '/' . implode('/', $params);
        }

        return $url;
    }
}