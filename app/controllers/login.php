<?php

/*
 * Author: Liang Shan Ji
 */

class Login extends Controller {

    function __construct() {
        parent::__construct();
    }

    function login() {
        $this->model->login();
    }
    
    function logout(){
        $this->model->logout();
    }

}
