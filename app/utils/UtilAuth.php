<?php

/*
 * Author: Liang Shan Ji
 */

class Auth {

    public static function checkLoggedIn() {

        $loggedIn = Session::get('is_user_logged_in');

        if ($loggedIn == false) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

    public static function checkAdmin() {

        $role = Session::get('user_role');

        if ($role == ROLE_USER) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

}
