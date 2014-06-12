<?php

/*
 * Author: Liang Shan Ji
 */

class UserAdministration_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function listUsers() {
        $attr = array('*');
        $condition = "WHERE user_role = :role ORDER BY user_surname, user_name ASC";
        $conditionArrayValues = array(
            'role' => 'user'
        );
        if (Session::get('user_role') == ROLE_OWNER) {
            $condition = "WHERE user_role <> :role ORDER BY user_surname, user_name ASC";
            $conditionArrayValues['role'] = 'owner';
        }
        return $this->db->select('users', $attr, $condition, $conditionArrayValues);
    }

    public function userCheckExist($data) {
        $condition = $this->dataFormatForUserCheckExist($data);
        return $this->db->rowCountNumber('users', array('*'), $condition[0], $condition[1]);
    }

    public function createUser($data) {
        $this->db->insert('users', $data);
    }

    public function deleteUser($id) {
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => $id
        );
        $this->db->delete('users', $condition, $conditionArrayValues);
    }

    public function singleUser($id) {
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => $id
        );
        return $this->db->select('users', array('*'), $condition, $conditionArrayValues);
    }

    public function editUserSave($data, $id) {
        $condition = "WHERE user_id = :user_id_old";
        $conditionArrayValues = array(
            'user_id_old' => $id
        );
        $this->db->update('users', $data, $condition, $conditionArrayValues);
    }

    private function dataFormatForUserCheckExist($data) {
        $condition = 'WHERE ';
        foreach ($data as $key => $value) {
            if ($value == '') {
                unset($data[$key]);
            } else if ($key == 'user_password' || $key == 'user_role' || $key == 'user_name' || $key == 'user_surname') {
                unset($data[$key]);
            } else {
                $condition .= " " . $key . " = :" . $key . " OR";
            }
        }
        $condition = rtrim($condition, 'OR');
        return array($condition, $data);
    }

}
