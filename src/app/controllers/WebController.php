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

    public function index(): void
    {
        $posts = $this->postModelConn->getPost();
        $users = $this->userModelConn->getUser();

        $this->view->render('index', ['posts' => $posts, 'users' => $users]);
    }

    public function post(array $params): void
    {
        $title = (string)$params['title'];
        $body = (string)$params['body'];
        $user = $this->userModelConn->getUserByName($_SESSION['username']);

        $this->postModelConn->sendPost($title, $body, $user['id']);
        header('Location: /');
        exit;
    }

    //TODO: 詳細記事表示部分
    public function postDetail(): void
    {
        $post_id = ltrim($_SERVER['QUERY_STRING'], 'post_id=');

        if ($post_id) {
            $post = $this->postModelConn->getPostById($post_id);
            if ($post) {
                $user = $this->userModelConn->getUserById($post['user_id']);
                $this->view->render('postDetail', ['post' => $post, 'post_id' => $post_id, 'user' => $user]);
            } else {
                echo 'Post not found';
            }
        } else {
            echo 'Post ID Required';
        }
    }

    public function postDelete(array $params): void
    {
        $post = $this->postModelConn->getPostById((int)$params['post_id']);
        $this->postModelConn->deletePost($post);
        header('Location: /');
        exit;
    }

    public function postUpdate(array $params): void
    {
        $post_id = (int)$params['post_id'];
        $post = $this->postModelConn->getPostById($post_id);
        $user = $this->userModelConn->getUserById($post['user_id']);
        $this->view->render('postUpdate', ['post' => $post, 'user' => $user]);
    }

    public function executeUpdate(array $params): void
    {
        $post_id = (int)$params['post_id'];
        $title = (string)$params['title'];
        $body = (string)$params['body'];

        if (strlen($title) === 0 || strlen($body) === 0) {
            echo 'Title and Body are both required';
        }
        $this->postModelConn->updatePost($post_id, $title, $body);
        header('Location: ' . '/postDetail?post_id=' . $post_id);
        exit;
    }

    //TODO: ユーザ部分

    public function login(): void
    {
        $this->view->render('login');
    }

    public function executeLogin(array $params): void
    {
        $username = (string)$params['username'];
        $password = (string)$params['password'];

        try{
            $loginInfo = $this->userModelConn->getUserByName($username);

            if (password_verify($password, $loginInfo['password'])) {
                $_SESSION['username'] = $loginInfo['username'];
                setcookie('username', $loginInfo['username'],
                    [
                        'expires' => 0,
                        'path' => '/',
                        'samesite' => 'lax',
                        'secure' => true,
                    ]);
                header('Location: /');
            }else{
                $this->view->render('login', ['err' => 'Invalid username or password']);
            }
        }catch (\TypeError $e){
            $this->view->render('login', ['err' => 'Invalid username or password']);
        }
    }

    public function register(): void
    {
        $this->view->render('register');
    }

    public function executeRegister(array $params): void
    {
        $email = (string)$params['email'];
        $username = (string)$params['username'];
        $password = (string)$params['password'];
        $image = $_FILES['user_image'];

        $this->fileUpload($image);
        $this->userModelConn->registerUser($email, $username, $password, $image['name']);

        header('Location: /login');
        exit;
    }

    public function fileUpload(array $file): void
    {
        $target_dir = '/var/www/html/src/images/users/';
        $target_file = $target_dir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($imageFileType !== 'jpg' && $imageFileType !== 'png' && $imageFileType !== 'jpeg') {
            echo 'Sorry, only JPG, JPEG, PNG files are allowed.';
        }

        if (file_exists($target_file)) {
            echo 'Sorry, file already exists.';
        }

        if ($file['size'] > 500000) {
            echo 'Sorry, your file is too large.';
        }

        move_uploaded_file($file['tmp_name'], $target_file);
    }

    public function logout(): void
    {
        session_destroy();
        setcookie('username', $_SESSION['username'], time() - 3600, '/');

        header('Location: /');
        exit;
    }
}
