<?php

/*
 * Author: Liang Shan Ji
 */

class Manager extends Controller {

    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
    }

    function index() {
        $this->renderArrayDefault('index');
    }

    function changePass() {
        $this->renderArrayDefault('changepassword');
        Session::set('password_success?', '');
    }

    function changePassword() {
        $data = array(
            'currentPassword' => filter_input(INPUT_POST, 'user_password'),
            'newPassword' => filter_input(INPUT_POST, 'user_password_new'),
            'confirmNewPassword' => filter_input(INPUT_POST, 'user_password_new_confirm')
        );
        $this->model->changePassword($data);
        header('Location: ' . URL . 'manager/changePass');
    }

    private function renderArrayDefault($filename) {
        $array = array(
            1 => "manager/menuaction",
            2 => "manager/$filename"
        );
        $this->view->renderArray($array);
    }

}
