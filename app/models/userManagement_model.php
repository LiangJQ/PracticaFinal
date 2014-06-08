<?php

/*
 * Author: Liang Shan Ji
 */

class UserManagement_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function changePassword() {
        $attr = array('user_password');
        $condition = "user_id = :user_id";
        $bindValues = array(
            'user_id' => Session::get('user_id')
        );
        $result = $this->db->select('users', $attr, $condition, $bindValues);
        $dbUserPass = $result->user_password;
        $currentPass = filter_input(INPUT_POST, 'user_password');
        $newPass = filter_input(INPUT_POST, 'user_password_new');
        $newConfirmPass = filter_input(INPUT_POST, 'user_password_new_confirm');

        if ($currentPass == $dbUserPass) {
            if ($newPass == $newConfirmPass) {
                $data = array(
                    'user_password' => $newPass
                );
                $condition = "user_id = :user_id";
                $bindValues = array(
                    'user_id' => Session::get('user_id')
                );
                $this->db->update('users', $data, $condition, $bindValues);
                Session::set('password_success?', PASSWORD_UPDATE_SUCCESFUL);
                header('Location: ' . URL . 'manager/page/changePasswordPage');
            } else {
                Session::set('password_success?', PASSWORD_NOT_MATCHING);
                header('Location: ' . URL . 'manager/page/changePasswordPage');
            }
        } else {
            Session::set('password_success?', PASSWORD_WRONG_CURRENT_PASSWORD);
            header('Location: ' . URL . 'manager/page/changePasswordPage');
        }
    }

}
