<?php

class PaginationHelper
{
    private $paginationDTO;

    public function __construct(PaginationDTO $paginationDTO)
    {
        $this->paginationDTO = $paginationDTO;
    }

    public function render()
    {
        $output = '<nav aria-label="Page navigation">';
        $output .= '<ul class="pagination">';

        // Previous link
        if ($this->paginationDTO->currentPage > 1) {
            $output .= '<li class="page-item">';
            $output .= '<a class="page-link" href="' . $this->paginationDTO->generateUrl($this->paginationDTO->currentPage - 1) . '">Previous</a>';
            $output .= '</li>';
        }

        // Page numbers
        for ($i = 1; $i <= $this->paginationDTO->totalPages; $i++) {
            $active = $i === $this->paginationDTO->currentPage ? 'active' : '';
            $output .= '<li class="page-item ' . $active . '">';
            $output .= '<a class="page-link" href="' . $this->paginationDTO->generateUrl($i) . '">' . $i . '</a>';
            $output .= '</li>';
        }

        // Next link
        if ($this->paginationDTO->currentPage < $this->paginationDTO->totalPages) {
            $output .= '<li class="page-item">';
            $output .= '<a class="page-link" href="' . $this->paginationDTO->generateUrl($this->paginationDTO->currentPage + 1) . '">Next</a>';
            $output .= '</li>';
        }

        $output .= '</ul>';
        $output .= '</nav>';

        return $output;
    }
}
