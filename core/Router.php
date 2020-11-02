<?php

namespace core;

class Router
{
    protected $routes = [];
    protected $params = [];
    protected $dirControllers = 'controllers\\';
    protected $path = '';

    public function __construct()
    {
        $routes = require_once $_SERVER['DOCUMENT_ROOT'].'/configs/routes.php';
        foreach ($routes as $key => $val){
            $this->add($key,$val);
        }
    }

    private function add(string $route, array $params) : void
    {
        $this->routes[$route] = $params;
    }

    private function match() : bool
    {
        $url = trim($_SERVER['REQUEST_URI'],'/');
        $newUrl = explode('?',$url)[0];
        foreach ($this->routes as $route => $params){
            if ($newUrl == $route) {
                $this->path = $this->getPath($params);
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run() : void
    {
        if ($this->match()) {
            $controller = new $this->path($this->params);
            $controller->main();
        }
    }

    public function getPath(array $params) : string
    {
        return $this->dirControllers.$params['controller'] .'Controller';
    }
}