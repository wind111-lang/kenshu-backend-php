<?php

namespace App\app\controllers;

use App\core\Controller;
use App\app\models\PostModel;
use App\app\models\UserModel;

class WebController extends Controller
{
    private $postModelConn;
    private $userModelConn;

    //TODO: 遷移処理
    public function __construct()
    {
        parent::__construct();
        $this->postModelConn = new PostModel();
        $this->userModelConn = new UserModel();
    }

    public function index($params)
    {
        $posts = $this->postModelConn->getPost();
        $this->view->render('index', ['posts' => $posts]);
    }

    public function post($params)
    {
        if (empty($params['title']) || empty($params['body'])) {
            echo 'Title and Body are both required';
        }
        $this->postModelConn->sendPost($params['title'], $params['body']);
        header('Location: /');
        exit;
    }
    //TODO: 詳細記事表示部分

    //TODO: ユーザ部分
}
