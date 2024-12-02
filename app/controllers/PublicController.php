<?php

namespace App\controllers;

use App\core\Controller;


class PublicController extends Controller
{
    public function __construct() {}
    public function index()
    {
        $this->render('Public', 'Home/index');
    }
}