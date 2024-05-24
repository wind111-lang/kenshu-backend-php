<?php

namespace App\core;

use App\app\controllers\WebController;

class Router
{
    public static function route()
    {
        // URLのpathを取得
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // slashを区切り文字として分割
        $url = explode('/', $url);
        // pathが存在する場合はそのまま, 存在しない場合はindexにする
        $method = $url[1] ? : 'index';

        if ($method === 'public') {
            // indexはpublicのindex.phpを呼び出しているため, Redirectさせる
            header('Location: /');
            exit;
        }

        $controller = new WebController();

        // 遷移先が存在するか確認
        if (method_exists($controller, $method)) {
            // HTTPメソッドによって処理を分岐
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
