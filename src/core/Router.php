<?php

namespace App\core;
class Router
{
    public function __construct() {
        echo "This is Router class\n";
    }
    public static function route()
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);


        $controller = !empty($url[0]) ? 'App\\app\\controllers\\' . ucfirst($url[0]) .
            'Controller' : 'App\\app\\controllers\\WebController';
        $method = !empty($url[1]) ? $url[1] : 'index';

        if (class_exists($controller)){
            $controller = new $controller;

            if (method_exists($controller, $method)){
                $httpMethod = $_SERVER['REQUEST_METHOD'];
                switch ($httpMethod){
                    case 'POST':
                        $controller->{$method}($_POST);
                        break;
                    case 'GET':
                        $controller->{$method}($_GET);
                        break;
                    case 'DELETE':
                        parse_str(file_get_contents('php://input'), $_DELETE);
                        $controller->{$method}($_DELETE);
                        break;
                    case 'PATCH':
                        parse_str(file_get_contents('php://input'), $_PATCH);
                        $controller->{$method}($_PATCH);
                        break;
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
