<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Handles login process
 */
class Login_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Compares passed id and password with database.
     * If matches set user's information to SESSION.
     * If not, exit to home page
     * @param array $data   : user's id and password
     * @return boolean  : true if logged in, otherwise false
     */
    public function login($data) {

        // get user's data
        $attr = array('user_id',
            'user_name',
            'user_surname',
            'user_password',
            'user_email',
            'user_role'
        );
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => $data['id']
        );
        $result = $this->db->select('users', $attr, $condition, $conditionArrayValues);

        // check if provided password matches the password in the database
        if ($data['password'] == $result->user_password) {

            // login process, write the user data into session
            Session::init();
            Session::set('is_user_logged_in', USER_LOGGED_IN);
            Session::set('user_id', $result->user_id);
            Session::set('user_name', $result->user_name);
            Session::set('user_surname', $result->user_surname);
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

    /**
     * Logout, exit to homepage, destroy SESSION
     */
    public function logout() {
        Session::destroy();
        header('location: ' . URL . 'index');
        exit;
    }

}
