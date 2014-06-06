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
        $sth = $this->db->prepare("SELECT user_id,
                                          user_name,
                                          user_password,
                                          user_role
                                   FROM   users
                                   WHERE  (user_id = :user_id)");
        $sth->execute(array(':user_id' => filter_input(INPUT_POST, 'user_id')));

        $count = $sth->rowCount();

//        // if there's NOT one result
//        if ($count != 1) {
//            $_SESSION["feedback_negative"][] = FEEDBACK_LOGIN_FAILED;
//            return false;
//        }
        // fetch one row (only have one result)
        $result = $sth->fetch();
        
        // check if provided password matches the password in the database
        if (filter_input(INPUT_POST, 'user_password') == $result->user_password) {

            // login process, write the user data into session
            Session::init();
            Session::set('is_user_logged_in', USER_LOGGED_IN);
            Session::set('user_id', $result->user_id);
            Session::set('user_name', $result->user_name);
            Session::set('user_role', $result->user_role);

            header('location: ' . URL . 'index');

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
