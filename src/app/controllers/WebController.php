<?php

namespace App\app\controllers;

use App\core\Controller;
use App\app\models\PostModel;
use App\app\models\UserModel;

class WebController extends Controller
{
    private $postModelConn;
    private $userModelConn;

    const POST_IMAGE_DIR = '/var/www/html/src/images/posts/post/';
    const THUMB_IMAGE_DIR = '/var/www/html/src/images/posts/thumb/';
    const USER_IMAGE_DIR = '/var/www/html/src/images/users/';

    //TODO: 遷移処理
    public function __construct()
    {
        parent::__construct();
        $this->postModelConn = new PostModel();
        $this->userModelConn = new UserModel();
    }

    public function index(): void
    {
        try {
            $posts = $this->postModelConn->getPost();
            $users = $this->userModelConn->getUser();
            $tags = $this->postModelConn->getTag();

            print_r($tags);

        } catch (\UnexpectedValueException $e) {
            $this->view->render('index', ['err' => $e->getMessage()]);
        }

        $this->view->render('index', ['posts' => $posts, 'users' => $users, 'tags' => $tags]);
    }

    public function post(array $params): void
    {
        $title = (string)$params['title'];
        $body = (string)$params['body'];
        $postImages = $_FILES['post_images'];
        $thumbImage = $_FILES['thumb_image'];
        $selectedTags = (array)$params['tags'];

        try {

            $user = $this->userModelConn->getUserByName($_SESSION['username']);
            $this->postModelConn->sendPost($title, $body, $user['id']);

            $post = $this->postModelConn->getLatestId();

            if($post['id']){
                $postId = $post['id'];
            }else{
                $postId = 1;
            }


            for($tag = 0; $tag < count($selectedTags); $tag++){
                $tagInfo = $this->postModelConn->getTagIdFromName($selectedTags[$tag]);
                $this->postModelConn->sendSelectedTag($postId, $tagInfo['id']);
            }


            $this->fileUpload($thumbImage, self::THUMB_IMAGE_DIR);
            $this->postModelConn->sendThumbImage($postId, $thumbImage['name']);


            $postCount = count($_FILES['post_images']['name']);

            for ($image=0; $image < $postCount; $image++) {
                $file = [
                    'name' => $postImages['name'][$image],
                    'type' => $postImages['type'][$image],
                    'tmp_name' => $postImages['tmp_name'][$image],
                    'error' => $postImages['error'][$image],
                    'size' => $postImages['size'][$image],
                ];

                $this->fileUpload($file, self::POST_IMAGE_DIR);
                $this->postModelConn->sendPostImage($postId, $file['name']);
            }

        } catch (\Exception $e) {
            $this->view->render('index', ['err' => $e->getMessage()]);
            return;
        }

        header('Location: /');
        exit;
    }

    //TODO: 詳細記事表示部分
    public function postDetail(): void
    {
        $postId = ltrim($_SERVER['QUERY_STRING'], 'post_id=');

        try {
            if ($postId) {
                $post = $this->postModelConn->getPostById($postId);
                if ($post) {
                    $user = $this->userModelConn->getUserById($post['user_id']);
                    $thumb = $this->postModelConn->getThumbImageFromPostId($postId);
                    $images = $this->postModelConn->getPostImageFromPostId($postId);
                    $tags = $this->postModelConn->getTagNameFromPostId($postId);

                    $this->view->render('postDetail', ['post' => $post, 'post_id' => $postId, 'user' => $user, 'thumb' => $thumb, 'images' => $images, 'tags' => $tags]);
                } else {
                    throw new \UnexpectedValueException('Invalid post ID');
                }
            } else {
                throw new \UnexpectedValueException('post ID is not set');
            }
        } catch (\Exception $e) {
            $this->view->render('postDetail', ['err' => $e->getMessage()]);
        }
    }

    public function postDelete(array $params): void
    {
        try {
            $post = $this->postModelConn->getPostById((int)$params['post_id']);
            $this->postModelConn->deletePost($post);
        } catch (\RuntimeException $e) {
            $this->view->render('postDetail', ['err' => $e->getMessage()]);
            return;
        }

        header('Location: /');
        exit;
    }

    public function postUpdate(array $params): void
    {
        $postId = (int)$params['post_id'];
        try {
            $post = $this->postModelConn->getPostById($postId);
            $user = $this->userModelConn->getUserById($post['user_id']);
        } catch (\UnexpectedValueException $e) {
            $this->view->render('postUpdate', ['err' => $e->getMessage()]);
        }

        $this->view->render('postUpdate', ['post' => $post, 'user' => $user]);
    }

    public function executeUpdate(array $params): void
    {
        $postId = (int)$params['post_id'];
        $title = (string)$params['title'];
        $body = (string)$params['body'];

        try {
            $this->postModelConn->updatePost($postId, $title, $body);
        } catch (\UnexpectedValueException $e) {
            $this->view->render('postUpdate', ['err' => $e->getMessage()]);
            return;
        }

        header('Location: ' . '/postDetail?post_id=' . $postId);
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

        try {
            $loginInfo = $this->userModelConn->getUserByName($username);

            if (password_verify($password, $loginInfo['password'])) {
                $_SESSION['username'] = $loginInfo['username'];
                setcookie('username', $loginInfo['username'],
                    [
                        'expires' => 3600,
                        'path' => '/',
                        'samesite' => 'lax',
                        'secure' => true,
                    ]);
                header('Location: /');
            }
        } catch (\RuntimeException $e) {
            $this->view->render('login', ['err' => $e->getMessage()]);
            return;
        } catch (\TypeError $e) {
            $this->view->render('login', ['err' => $e->getMessage()]);
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


        try {
            $this->fileUpload($image, self::USER_IMAGE_DIR);
            $this->userModelConn->registerUser($email, $username, $password, $image['name']);
        } catch (\Exception $e) {
            $this->view->render('register', ['err' => $e->getMessage()]);
            return;
        }

        header('Location: /login');
        exit;
    }

    public function fileUpload(array $file, string $targetDir): void
    {
        $targetFile = $targetDir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


        if ($imageFileType !== 'jpg' && $imageFileType !== 'png' && $imageFileType !== 'jpeg') {
            throw new \Exception('Sorry, only JPG, JPEG, PNG files are allowed.');
        }

        if (file_exists($targetFile)) {
            throw new \Exception('Sorry, some file are already exists.');
        }

        if ($file['size'] > 5000000) {
            throw new \Exception('Sorry, your file is too large.');
        }
        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            throw new \Exception('Sorry, there was an error uploading your file.');
        }
    }

    public function logout(): void
    {
        session_destroy();
        setcookie('username', $_SESSION['username'], time() - 3600, '/');

        header('Location: /');
        exit;
    }
}
