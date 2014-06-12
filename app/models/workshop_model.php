<?php

/*
 * Author: Liang Shan Ji
 */

class Workshop_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getUserActivity($userId) {
        $condition = "WHERE workshop_user_id = $userId";
        return $this->db->select('workshop', array('*'), $condition);
    }

    public function listActivitiesLimited() {
        $condition = "WHERE workshop_date BETWEEN CURRENT_DATE + " . START_DAY . " AND CURRENT_DATE + INTERVAL " . MAX_LIMIT_DAY_TO_CREATE . " DAY ";
        $result = $this->db->select('workshop', array('*'), $condition);
        $dataArray = array();
        if (!empty($result)) {
            if (is_array($result)) {
                foreach ($result as $value) {
                    $dataArray[] = $value->workshop_date;
                }
            } else {
                $dataArray[] = $result->workshop_date;
            }
        }
        return $dataArray;
    }

    public function createActivity($data) {
        $this->db->insert('workshop', $data);
    }

    public function editActivitySave($data, $id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->update('workshop', $data, $condition, $conditionArrayValues);
    }

    public function deleteActivity($id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->delete('workshop', $condition, $conditionArrayValues);
    }

    public function confirmActivitySave($id) {
        $data = array(
            'workshop_request' => 'Y'
        );
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->update('workshop', $data, $condition, $conditionArrayValues);
    }

    public function singleActivity($id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        return $this->db->select('workshop', array('*'), $condition, $conditionArrayValues);
    }

    public function singleActivityByData($data) {
        $condition = $this->dataFormatForActivityCheckExist($data);
        return $this->db->select('workshop', array('*'), $condition[0], $condition[1]);
    }

    public function activityCheckExist($data) {
        $condition = $this->dataFormatForActivityCheckExist($data);
        return $this->db->rowCountNumber('workshop', array('*'), $condition[0], $condition[1]);
    }

    public function listUsers() {
        $attr = array('*');
        $condition = "ORDER BY user_surname, user_name ASC";
        return $this->db->select('users', $attr, $condition);
    }

    private function dataFormatForActivityCheckExist($data) {
        $condition = 'WHERE ';
        foreach ($data as $key => $value) {
            if ($key == 'workshop_name' || $key == 'workshop_date') {
                $condition .= " " . $key . " = :" . $key . " OR";
            } else {
                unset($data[$key]);
            }
        }

        $condition = rtrim($condition, 'OR');
        return array($condition, $data);
    }

}
