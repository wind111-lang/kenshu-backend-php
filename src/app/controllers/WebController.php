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
        $this->modelConn = new PostModelController();
    }
    public function index($params)
    {
        $posts = $this->modelConn->getPost();
        $this->view->render('index', ['posts' => $posts]);
    }

    public function post($params)
    {
        $this->modelConn->sendPost($params['title'], $params['body']);
        header('Location: /');
        exit;
    }
    public function login($params)
    {

    }
}
