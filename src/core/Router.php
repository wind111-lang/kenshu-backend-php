<?php

namespace App\core;
class Router
{
    public static function route()
    {
        $requestURI = $_SERVER['REQUEST_URI'] ?? '/';
        $url = rtrim($requestURI, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);


        $controllerName = "App\\app\\controllers\\WebController";
        $method = !empty($url[1]) ? $url[1] : 'index';

        if ($method === 'public'){
            // indexはpublicのindex.phpを呼び出しているため, Redirectさせる
            header('Location: /');
            exit;
        }

        if (class_exists($controllerName)){
            $controller = new $controllerName;
            if (method_exists($controller, $method)){
                $httpMethod = $_SERVER['REQUEST_METHOD'];
                switch ($httpMethod){
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
            }else{
                echo 'Method not found';
            }
        }else{
            echo 'Controller not found';
        }
    }
}
