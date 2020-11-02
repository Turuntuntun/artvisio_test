<?php
/**
 * Created by PhpStorm.
 * User: Юра
 * Date: 30.10.2020
 * Time: 4:02
 */

namespace core;

use models;

abstract class Controller
{
    public $dir = 'models';
    public $view;
    public $model;
    public $params;

    public function __construct($route)
    {
        $this->params = $route;
        $this->model = $this->loadModel($route['controller']);
        $this->view = new View($route);
    }

    public function loadModel(string $name) :object
    {
        $path = $this->dir.'\\'.ucfirst($name).'Model';
        return new $path;
    }


}