<?php

namespace App\app\controllers;

use App\core\Controller;

class WebController extends Controller
{
    //TODO: 遷移処理
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        echo 'Hello World';
    }

    public function login()
    {
        echo 'Login';
    }
}
