<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Handles user's information
 */
class Manager_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Changes password of users
     * Update database
     * @param array $data   : user's information data
     */
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
