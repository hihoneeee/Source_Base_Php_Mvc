<?php

namespace App\Helpers;

class UrlAction
{
    public static function action($area = 'public', $controller, $action = 'index', $params = [])
    {
        // Xác định khu vực (admin hoặc public)
        $areaPrefix = ($area === 'admin') ? '/admin' : '';

        // Xây dựng URL cơ bản với khu vực
        $url = "$areaPrefix/$controller";

        // Thêm action nếu không phải là 'index'
        if ($action !== 'index') {
            $url .= "/$action";
        }

        // Tách path và query parameters
        $pathParams = [];
        $queryParams = [];

        foreach ($params as $key => $value) {
            if (is_int($key)) {
                // Xử lý các giá trị là path parameters
                $pathParams[] = $value;
            } else {
                // Xử lý các giá trị là query parameters
                $queryParams[$key] = $value;
            }
        }

        // Đính kèm path parameters vào URL
        if (!empty($pathParams)) {
            $url .= '/' . implode('/', $pathParams);
        }

        // Tạo chuỗi query từ mảng associative
        $queryString = http_build_query($queryParams);
        if ($queryString) {
            $url .= '?' . $queryString;
        }

        return $url;
    }
}
