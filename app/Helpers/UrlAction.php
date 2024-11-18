<?php

class UrlAction
{
    public static function action($controller, $action = 'index', $params = [])
    {
        $url = BASE_URL . "/$controller";

        // Add the action if it’s not the default 'index' action
        if ($action !== 'index') {
            $url .= "/$action";
        }

        // Separate path and query parameters
        $pathParams = [];
        $queryParams = [];

        foreach ($params as $key => $value) {
            if (is_int($key)) {
                // Treat numeric keys as path parameters
                $pathParams[] = $value;
            } else {
                // Treat associative keys as query parameters
                $queryParams[$key] = $value;
            }
        }

        // Append path parameters to the URL
        if (!empty($pathParams)) {
            $url .= '/' . implode('/', $pathParams);
        }

        // Build query string from associative array
        $queryString = http_build_query($queryParams);
        if ($queryString) {
            $url .= '?' . $queryString;
        }

        return $url;
    }
}