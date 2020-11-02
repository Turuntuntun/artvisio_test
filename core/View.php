<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 30.10.2020
 * Time: 19:23
 */

namespace core;


class View
{
    public $dir = 'layouts/';
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $this->dir.$route['controller'];
    }

    public function render(string $title, array $vars = []) : void
    {
        $pathContent  = $this->dir.$this->route['controller'].'.php';
        $pathLayout = $this->dir.$this->layout.'.php';
        ob_start();
        require $pathContent;
        $content = ob_get_clean();
        require $pathLayout;
    }

}