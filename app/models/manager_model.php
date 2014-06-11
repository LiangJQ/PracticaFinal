<?php

/*
 * Author: Liang Shan Ji
 */

class Manager_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function changePassword($data) {
        $attr = array('user_password');
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => Session::get('user_id')
        );
        $result = $this->db->select('users', $attr, $condition, $conditionArrayValues);
        $dbUserPass = $result->user_password;
        $currentPass = $data['currentPassword'];
        $newPass = $data['newPassword'];
        $newConfirmPass = $data['confirmNewPassword'];

        if ($currentPass == $dbUserPass) {
            if ($newPass == $newConfirmPass) {
                $data = array(
                    'user_password' => $newPass
                );
                $condition = "WHERE user_id = :user_id";
                $conditionArrayValues = array(
                    'user_id' => Session::get('user_id')
                );
                $this->db->update('users', $data, $condition, $conditionArrayValues);
                Session::set('password_success?', PASSWORD_UPDATE_SUCCESFUL);
            } else {
                Session::set('password_success?', PASSWORD_NOT_MATCHING);
            }
        } else {
            Session::set('password_success?', PASSWORD_WRONG_CURRENT_PASSWORD);
        }
    }

}
