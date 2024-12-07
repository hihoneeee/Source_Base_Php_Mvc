<?php

namespace App\controllers;

use App\core\Controller;
use App\Services\FakeDataService;

class FakeDataController extends Controller
{
    private $_fakeDataService;

    public function __construct(FakeDataService $fakeDataService)
    {
        $this->_fakeDataService = $fakeDataService;
    }
    public function generateAndInsertData()
    {
        $response = $this->_fakeDataService->generateAndInsertData();
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('public', '', 'index');
        } else {
            $this->redirectToAction('public', '', 'index');
        }
    }
}
