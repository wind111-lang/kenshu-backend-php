<?php

namespace App\app\controllers;

use App\core\Controller;
use App\app\models\PostModelController;
use App\app\models\UserModelController;

class WebController extends Controller
{
    private $modelConn;

    //TODO: 遷移処理
    public function __construct()
    {
        parent::__construct();
        $this->modelConn = new ModelController();
    }

    public function index($params)
    {
        $posts = $this->modelConn->getPost();
        $this->view->render('index', ['posts' => $posts]);
    }

    public function post($params)
    {
        if (empty($params['title']) || empty($params['body'])) {
            echo 'Title and Body are both required';
        }
        $this->modelConn->sendPost($params['title'], $params['body']);
        header('Location: /');
        exit;
    }
