<?php

namespace App\DTOs\Common;

class PaginationDTO
{
    protected $currentPage;
    protected $totalPages;
    protected $baseUrl;
    protected $isPagingUse = false;

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

    public function setCurrentPage(int $page): void
    {
        $this->currentPage = $page;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $count): void
    {
        $this->totalPages = $count;
    }

    public function setIsPagingUse(bool $isPagingUse): void
    {
        $this->isPagingUse = $isPagingUse;
    }

    public function generateUrl($page)
    {
        return '/' . $this->baseUrl . '?page=' . $page;
    }
}
