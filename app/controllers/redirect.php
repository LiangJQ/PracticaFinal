<?php

/* 
 * Author: Liang Shan Ji
 */

class Redirect extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function url($url) {
        $this->model->url($url);
    }

}