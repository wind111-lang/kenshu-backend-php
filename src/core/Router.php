<?php

namespace App\core;

use App\app\controllers\WebController;

class Router
{
    public static function route()
    {
        $requestURI = $_SERVER['REQUEST_URI'] ?? '/';
        $url = parse_url($requestURI, PHP_URL_PATH);

        // 文字列をURL Encodeする
        $url = filter_var($url, FILTER_SANITIZE_URL);

        // URLをslashで分割する
        $url = explode('/', $url);

        // URLのpathを取得, なければindexとする
        $method = strlen($url[1]) !== 0 ? $url[1] : 'index';

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
