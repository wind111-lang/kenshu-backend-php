<?php

namespace App\core;

class View
{
    public function render($template, $data = [])
    {
        extract($data);
        require '../app/view/' . $template . '.php';
    }
}
