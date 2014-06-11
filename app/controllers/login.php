<?php

/*
 * Author: Liang Shan Ji
 */

class Login extends Controller {

    function __construct() {
        parent::__construct();
    }

    function login() {
        $data = array(
            'id' => filter_input(INPUT_POST, 'user_id'),
            'password' => filter_input(INPUT_POST, 'user_password')
        );
        $this->model->login($data);
    }
    
    function logout(){
        $this->model->logout();
    }

}
