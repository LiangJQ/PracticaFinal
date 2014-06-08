<?php

/*
 * Author: Liang Shan Ji
 */

class Login_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function login() {

        // get user's data
        $attr = array('user_id',
            'user_name',
            'user_password',
            'user_email',
            'user_role'
        );
        $condition = "user_id = :user_id";
        $bindValues = array(
            'user_id' => filter_input(INPUT_POST, 'user_id')
        );
        $result = $this->db->select('users', $attr, $condition, $bindValues);

        // check if provided password matches the password in the database
        if (filter_input(INPUT_POST, 'user_password') == $result->user_password) {

            // login process, write the user data into session
            Session::init();
            Session::set('is_user_logged_in', USER_LOGGED_IN);
            Session::set('user_id', $result->user_id);
            Session::set('user_name', $result->user_name);
            Session::set('user_email', $result->user_email);
            Session::set('user_role', $result->user_role);

            header('location: ' . URL . 'invitation');

            // return true to make clear the login was successful
            return true;
        }

        header('location: ' . URL . 'index');

        // default return
        return false;
    }

    public function logout() {
        echo 'logout';
        Session::destroy();
        header('location: ' . URL . 'index');
        exit;
    }

}
