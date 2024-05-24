<?php

namespace App\core;

use App\app\controllers\WebController;

class Router
{
    public static function route()
    {
        $requestURI = $_SERVER['REQUEST_URI'] ?? '/';
        $url = filter_var($requestURI, FILTER_SANITIZE_URL);
        // 文字列をURL Encodeする
        $url = explode('/', $url);
        // URLをslashで分割する
        $method = strlen($url[1]) !== 0 ? $url[1] : 'index';
        // URLの1番目の要素を取得, なければindexを取得する

        if ($method === 'public') {
            // indexはpublicのindex.phpを呼び出しているため, Redirectさせる
            header('Location: /');
            exit;
        }

        $controller = new WebController();

        if (method_exists($controller, $method)) {
            // 遷移先が存在するか確認
            $httpMethod = $_SERVER['REQUEST_METHOD'];
            switch ($httpMethod) {
                case 'POST':
                    $controller->{$method}($_POST);
                    break;
                case 'GET':
                    $controller->{$method}($_GET);
                    break;
                //TODO: PUT, DELETE, PATCHの処理を追加
                default:
                    echo 'HTTP method not allowed';
                    break;
            }
        } else {
            echo 'Method not found';
        }
    }
}
