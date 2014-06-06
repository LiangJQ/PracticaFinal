<?php

/*
 * Author: Liang Shan Ji
 */

class Redirect_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function url($url) {
        header('Location: ' . $url);
        exit();
    }

}
