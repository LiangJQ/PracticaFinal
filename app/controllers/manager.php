<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Manages user information
 */
class Manager extends Controller {

    /**
     * Checks if user is logged in
     * Exit to home page if user is not logged in.
     */
    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
    }

    /**
     * Base page
     */
    function index() {
        $this->_renderArrayDefault('index');
    }

    /**
     * Redirects to change password page
     */
    function changePass() {
        $this->_renderArrayDefault('changepassword');
        Session::set('password_success?', '');
    }

    /**
     * Changes password of the user
     */
    function changePassword() {
        $data = array(
            'currentPassword' => filter_input(INPUT_POST, 'user_password'),
            'newPassword' => filter_input(INPUT_POST, 'user_password_new'),
            'confirmNewPassword' => filter_input(INPUT_POST, 'user_password_new_confirm')
        );
        $this->model->changePassword($data);
        header('Location: ' . URL . 'manager/changePass');
    }

    /**
     * Shows a view called $filename
     * @param string $filename  : filename to be shown in view
     */
    private function _renderArrayDefault($filename) {
        $array = array(
            1 => "manager/menuaction",
            2 => "manager/$filename"
        );
        $this->view->renderArray($array);
    }

}
