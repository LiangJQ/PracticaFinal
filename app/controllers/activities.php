<?php

/*
 * Author: Liang Shan Ji
 */

class Activities extends Controller{

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('activities/index');
    }

}
