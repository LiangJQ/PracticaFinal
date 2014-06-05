<?php

/*
 * Author: Liang Shan Ji
 */

class Help extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function other($arg = false) {
        echo 'Other Method<br>';
        echo 'Optional' . $arg . '<br>';
        
        require MODELS_PATH . 'help_model.php';
        $model = new Help_Model();
    }

}
