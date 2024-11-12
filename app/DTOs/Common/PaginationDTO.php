<?php

class PaginationDTO
{
    public $totalPages;
    public $currentPage;

    public function __construct($totalPages, $currentPage)
    {
        $this->totalPages = $totalPages;
        $this->currentPage = $currentPage;
    }

    // Method to generate URLs for pagination links
    public function generateUrl($page)
    {
        $params = $_GET;
        $params['page'] = $page;

        // Remove 'url' parameter if it exists
        unset($params['url']);

        return '?' . http_build_query($params);
    }
}
