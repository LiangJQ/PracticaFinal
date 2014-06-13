<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Handle the login process
 */
class Login extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Login action
     */
    function login() {
        $data = array(
            'id' => filter_input(INPUT_POST, 'user_id'),
            'password' => filter_input(INPUT_POST, 'user_password')
        );
        $this->model->login($data);
    }
    
    /**
     * Logout action
     */
    function logout(){
        $this->model->logout();
    }

}
