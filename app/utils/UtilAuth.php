<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Simply checks if user is logged in or is admin or not.
 */
class Auth {

    /**
     * Checks if user is logged in
     */
    public static function checkLoggedIn() {

        $loggedIn = Session::get('is_user_logged_in');

        if ($loggedIn == false) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }
    
    /**
     * Checks if user is admin
     */
    public static function checkAdmin() {

        $role = Session::get('user_role');

        if ($role == ROLE_USER) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

}
