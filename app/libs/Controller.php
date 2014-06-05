<?php

/*
 * Author: Liang Shan Ji
 */

class Controller {

    function __construct() {
        
        Session::init();
        
        $this->view = new View();
    }

    public function loadModel($name) {
        $path = MODELS_PATH . $name . '_model.php';

        if (file_exists($path)) {
            require $path;

            $modelClass = $name . '_Model';
            $this->model = new $modelClass();
        }
    }

}
