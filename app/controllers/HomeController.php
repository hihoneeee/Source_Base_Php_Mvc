<?php

require_once './app/core/Controller.php';

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Trang chủ',
        ];
        $this->render('Home/index', ['data' => $data]);
    }

    public function notFound()
    {
        $this->render('Home/notFound');
    }
}
