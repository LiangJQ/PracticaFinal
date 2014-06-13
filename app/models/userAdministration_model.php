<?php

/*
 * Author: Liang Shan Ji
 */


/**
 * Handles users administration
 */
class UserAdministration_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Fetches all users sorted except the owner and other admins if user is owner
     * else it only fetches users.
     * @return array    : array of users object
     */
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

    /**
     * Return the number of rows searched with passed data from database
     * @param array $data   : user's data
     * @return int  : number of rows
     */
    public function userCheckExist($data) {
        $condition = $this->dataFormatForUserCheckExist($data);
        return $this->db->rowCountNumber('users', array('*'), $condition[0], $condition[1]);
    }

    /**
     * Creates an user with passed data.
     * Insert into database
     * @param array $data   : user data
     */
    public function createUser($data) {
        $this->db->insert('users', $data);
    }

    /**
     * Deletes user from database
     * @param int $id   : user id
     */
    public function deleteUser($id) {
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => $id
        );
        $this->db->delete('users', $condition, $conditionArrayValues);
    }

    /**
     * Fetches the user with passed id from database
     * @param int $id   : user's  id
     * @return object   : user object
     */
    public function singleUser($id) {
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => $id
        );
        return $this->db->select('users', array('*'), $condition, $conditionArrayValues);
    }

    /**
     * Saves user's information with passed data
     * Update database
     * @param array $data   :  user data
     * @param int $id   : user id
     */
    public function editUserSave($data, $id) {
        $condition = "WHERE user_id = :user_id_old";
        $conditionArrayValues = array(
            'user_id_old' => $id
        );
        $this->db->update('users', $data, $condition, $conditionArrayValues);
    }

    /**
     * Reorganizes data and create a condition string for checking
     * if an user exists.
     * @param array $data   : user data
     * @return array        : array[0] = condition, array[1] = activityd data
     */
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
