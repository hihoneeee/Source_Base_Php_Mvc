<?php

namespace App\controllers;

use App\core\Controller;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\UserService;
use App\DTOs\Post\SearchCondition;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportController extends Controller
{
    private $_postService;
    private $_userService;
    private $_categoryService;

    public function __construct(PostService $postService, UserService $userService, CategoryService $categoryService)
    {
        $this->_postService = $postService;
        $this->_categoryService = $categoryService;
        $this->_userService = $userService;
    }

    public function index()
    {
        $categories = $this->_categoryService->getAll();
        $users = $this->_userService->getAll();

        $this->render('Admin', 'Report/report', [
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    public function reportTime()
    {
        $this->render('Admin', 'Report/reportByTime', []);
    }

    public function report()
    {
        try {
            // Load file template
            $templateFile = './Template/template.xlsx'; // Path to the template file
            $spreadsheet = IOFactory::load($templateFile);
            $sheet = $spreadsheet->getActiveSheet();

            // Clear placeholder data if any
            $sheet->removeRow(4, 100); // Remove existing rows starting from row 4

            // Set up headers
            $sheet->setCellValue('B3', 'ID');
            $sheet->setCellValue('C3', 'Tiêu đề');
            $sheet->setCellValue('D3', 'Tác giả');
            $sheet->setCellValue('E3', 'Danh mục');
            $sheet->setCellValue('F3', 'Trạng thái');

            // Get data from database
            $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
            $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';

            $condition = new SearchCondition($title, $userId, $categoryId);
            $condition->setCurrentPage($page);
            $condition->setIsPagingUse(true);

            $data = $this->_postService->getListPostsReport($condition);

            // Populate rows with data
            $row = 4;
            foreach ($data->data as $item) {
                $sheet->setCellValue("B{$row}", $item['id']);
                $sheet->setCellValue("C{$row}", $item['title']);
                $sheet->setCellValue("D{$row}", $item['fullName']);
                $sheet->setCellValue("E{$row}", $item['category']);
                $sheet->setCellValue("F{$row}", $item['status']);
                $row++;
            }

            // Page setup for PDF export
            $sheet->getPageSetup()
                ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            $sheet->getPageSetup()->setFitToWidth(1);
            $sheet->getPageSetup()->setFitToHeight(0);

            // Clean any previous output buffer
            ob_end_clean();

            // Export file as PDF
            header('Content-Type: application/pdf; charset=UTF-8');
            header('Content-Disposition: attachment; filename="Report_' . date('Ymd_His') . '.pdf"');

            $writer = IOFactory::createWriter($spreadsheet, 'Dompdf');
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            $this->redirectToAction('admin', 'report', 'index');
        }
    }

    public function search()
    {
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
        $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';

        $condition = new SearchCondition($title, $userId, $categoryId, null);
        $condition->setCurrentPage($page);
        $condition->setIsPagingUse(true);

        $categories = $this->_categoryService->getAll();
        $users = $this->_userService->getAll();
        $response = $this->_postService->getListPostsReport($condition);

        $this->render('Admin', 'Report/report', [
            'posts' => $response,
            'condition' => $condition,
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    public function reportTimeSearch()
    {
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $time = isset($_POST['time']) ? $_POST['time'] : '';

        $condition = new SearchCondition(null, null, null, $time);
        $condition->setCurrentPage($page);
        $condition->setIsPagingUse(true);

        $response = $this->_postService->getListReportByTime($condition);

        $this->render('Admin', 'Report/reportByTime', [
            'posts' => $response,
            'condition' => $condition
        ]);
    }
}