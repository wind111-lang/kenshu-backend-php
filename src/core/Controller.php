<?php

namespace App\core;

class Controller
{
    //TODO: ビューのインスタンス
    protected $view;
    public function __construct()
    {
        $this->view = new View();
    }
}
