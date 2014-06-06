<?php

/* 
 * Author: Liang Shan Ji
 */

class User extends Controller {

    function __construct() {
        parent::__construct();
        
        $loggedIn = Session::get('is_user_logged_in');
        $role = Session::get('user_role');
        
        if ($loggedIn == false || $role != 'user') {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

    function index() {
        $this->view->render('user/index');
    }

}