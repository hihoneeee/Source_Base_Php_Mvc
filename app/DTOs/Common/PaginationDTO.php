<?php

class PaginationDTO
{
    private $currentPage;
    private $totalPages;
    private $baseUrl;

    public function __construct($currentPage, $totalPages, $baseUrl)
    {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->baseUrl = $baseUrl;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function generateUrl($page)
    {
        return BASE_URL . '/' . $this->baseUrl  . '?page=' . $page;
    }
}