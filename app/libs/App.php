<?php

/*
 * Author: Liang Shan Ji
 */

class App {

    function __construct() {

        $urlAll = filter_input(INPUT_GET, 'url') ? filter_input(INPUT_GET, 'url') : null;
        $url = explode('/', rtrim($urlAll, '/'));

        if (empty($url[0])) {
            require CONTROLLERS_PATH . 'index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }

        $file = CONTROLLERS_PATH . $url[0] . '.php';

        if (file_exists($file)) {
            require $file;
        } else {
            $this->error();
        }

        $controller = new $url[0];
        $controller->loadModel($url[0]);

        // calling methods
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->error();
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}();
                } else {
                    $this->error();
                }
            } else {
                $controller->index();
            }
        }
    }

    function error() {
        require CONTROLLERS_PATH . 'error.php';
        $controller = new Error();
        $controller->index();
        return false;
    }

}
