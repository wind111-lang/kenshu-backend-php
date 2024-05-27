<?php

namespace App\app\controllers;

use App\core\Controller;
use App\app\models\PostModel;
use App\app\models\UserModel;
use JetBrains\PhpStorm\NoReturn;

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

    public function index(): void
    {
        $posts = $this->postModelConn->getPost();
        $this->view->render('index', ['posts' => $posts]);
    }

    public function post(array $params): void
    {
        $title = (string)$params['title'];
        $body = (string)$params['body'];

        if (strlen($title) === 0 || strlen($body) === 0){
            echo 'Title and Body are both required';
        }
        $this->postModelConn->sendPost($title, $body);
        header('Location: /');
        exit;
    }
    //TODO: 詳細記事表示部分
    public function postdetail() : void
    {
        $post_id = ltrim($_SERVER['QUERY_STRING'], 'post_id=');

        if ($post_id) {
            $post = $this->postModelConn->getPostById($post_id);
            if ($post) {
                $this->view->render('postdetail', ['post' => $post, 'post_id' => $post_id]);
            } else {
                echo 'Post not found';
            }
        } else {
            echo 'Post ID Required';
        }
    }

    public function postdelete(array $params): void
    {
        $post = $this->postModelConn->getPostById((int)$params['post_id']);
        $this->postModelConn->deletePost($post);
        header('Location: /');
        exit;
    }

    public function postupdate(array $params): void
    {
        $post_id = (int)$params['post_id'];
        $post = $this->postModelConn->getPostById($post_id);
        $this->view->render('postupdate', ['post' => $post]);
    }

    public function executeupdate(array $params): void
    {
        $post_id = (int)$params['post_id'];
        $title = (string)$params['title'];
        $body = (string)$params['body'];

        if (strlen($title) === 0 || strlen($body) === 0){
            echo 'Title and Body are both required';
        }
        $this->postModelConn->updatePost($post_id, $title, $body);
        header('Location: ' . '/postdetail?post_id=' . $post_id);
        exit;
    }

    //TODO: ユーザ部分
}
