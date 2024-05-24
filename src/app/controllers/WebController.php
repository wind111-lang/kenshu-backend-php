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

    public function postdetail($params)
    {
        $post_id = ltrim($_SERVER['QUERY_STRING'], 'post_id=');
        if ($post_id) {
            $post = $this->modelConn->getPostById($post_id);
            if ($post) {
                $this->view->render('postdetail', ['post' => $post, 'post_id' => $post_id]);
            }else{
                echo 'Post not found';
            }
        }else{
            echo 'Post ID Required';
        }
    }
