<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Base controller class. Other controllers extend this class
 * 
 * When a controller is created, starts session and create a view object
 */
class Controller {

    function __construct() {
        
        Session::init();
        
        $this->view = new View();
    }

    /**
     * Loads model with given name
     * 
     * @param model class with name given
     */
    public function loadModel($name) {
        $path = MODELS_PATH . $name . '_model.php';

        if (file_exists($path)) {
            require $path;

            $modelClass = $name . '_Model';
            $this->model = new $modelClass();
        }
    }

}
