<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Home page
 */
class Index extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('index/index');
    }

}
