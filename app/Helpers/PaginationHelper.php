<?php

namespace App\Helpers;

use App\DTOs\Common\PaginationDTO;

class PaginationHelper
{
    public static function render(PaginationDTO $paginationDTO)
    {
        $currentPage = $paginationDTO->getCurrentPage();
        $totalPages = $paginationDTO->getTotalPages();  

        // Kiểm tra xem đường dẫn hiện tại có nằm trong khu vực admin hay không
        $isInAdminArea = strpos(trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 'admin') === 0;

        if ($totalPages > 1) {
            echo '<nav aria-label="Page navigation example" class="flex justify-center">';
            echo '<ul class="flex items-center -space-x-px h-8 text-sm">';

            // Previous button
            echo '<li>';
            echo '<a href="' . ($isInAdminArea ? '/admin' : '') . $paginationDTO->generateUrl(max(1, $currentPage - 1)) . '" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
            echo '<i class="ri-arrow-left-s-line"></i>';
            echo '</a>';
            echo '</li>';

            // Page numbers
            for ($i = 1; $i <= $totalPages; $i++) {
                $isActive = ($i == $currentPage)
                    ? 'text-blue-600 border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white'
                    : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white';

                echo '<li>';
                echo '<a href="' . ($isInAdminArea ? '/admin' : '') . $paginationDTO->generateUrl($i) . '" class="flex items-center justify-center px-3 h-8 leading-tight ' . $isActive . '">';
                echo $i;
                echo '</a>';
                echo '</li>';
            }

            // Next button
            echo '<li>';
            echo '<a href="' . ($isInAdminArea ? '/admin' : '') . $paginationDTO->generateUrl(min($totalPages, $currentPage + 1)) . '" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">';
            echo '<i class="ri-arrow-right-s-line"></i>';
            echo '</a>';
            echo '</li>';

            echo '</ul>';
            echo '</nav>';
        }
    }
}