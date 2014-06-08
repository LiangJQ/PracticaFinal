<?php

/*
 * Author: Liang Shan Ji
 */

class UserManagement extends Controller {

    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
    }
    
    function changePassword(){
        $this->model->changePassword();
    }

}
