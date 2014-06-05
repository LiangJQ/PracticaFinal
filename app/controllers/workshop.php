<?php

/* 
 * Author: Liang Shan Ji
 */

class Workshop extends Controller {

    function __construct() {
        parent::__construct();
        
        if (empty(Session::get('is_user_logged_in'))) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

    function index() {
        $this->view->render('workshop/index');
    }

}