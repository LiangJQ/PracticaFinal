<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Shows an error page.
 */
class Error extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    /**
     * Shows an error view page.
     */
    function index() {
        $this->view->render('error/index');
    }

}
