<?php

/*
 * Author: Liang Shan Ji
 */

class ActivityAdministration_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function listActivities() {
        $condition = "ORDER BY workshop_date ASC";
        return $this->db->select('workshop', array('*'), $condition);
    }

    public function listActivitiesLimited() {
        $condition = "WHERE workshop_date BETWEEN CURRENT_DATE + " . START_DAY . " AND CURRENT_DATE + INTERVAL " . MAX_LIMIT_DAY_TO_CREATE . " DAY ";
        $result = $this->db->select('workshop', array('*'), $condition);
        $dataArray = array();
        foreach ($result as $key => $value) {
            $dataArray[] = $value->workshop_date;
        }
        return $dataArray;
    }

    public function activityCheckExist($data) {
        $condition = $this->dataFormatForActivityCheckExist($data);
        return $this->db->rowCountNumber('workshop', array('*'), $condition[0], $condition[1]);
    }

    public function createActivity($data) {
        $this->db->insert('workshop', $data);
    }

    public function deleteActivity($id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->delete('workshop', $condition, $conditionArrayValues);
    }

    public function singleActivity($id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        return $this->db->select('workshop', array('*'), $condition, $conditionArrayValues);
    }

    public function singleActivityByManagerId($id) {
        $condition = "WHERE workshop_user_id = :workshop_user_id";
        $conditionArrayValues = array(
            'workshop_user_id' => $id
        );
        return $this->db->select('workshop', array('*'), $condition, $conditionArrayValues);
    }

    public function editActivitySave($data, $id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->update('workshop', $data, $condition, $conditionArrayValues);
    }

    public function listActivitiesAuthorize() {
        $condition = "WHERE workshop_request = :workshop_request AND workshop_authorize = :workshop_authorize ORDER BY workshop_date ASC";
        $conditionArrayValues = array(
            'workshop_request' => 'Y',
            'workshop_authorize' => 'P'
        );
        return $this->db->select('workshop', array('*'), $condition, $conditionArrayValues);
    }

    public function authorizeActivity($id) {
        $data = array(
            'workshop_authorize' => 'Y'
        );
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->update('workshop', $data, $condition, $conditionArrayValues);
    }

    public function denyActivity($id) {
        $data = array(
            'workshop_authorize' => 'N'
        );
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->update('workshop', $data, $condition, $conditionArrayValues);
    }

    private function dataFormatForActivityCheckExist($data) {
        $condition = 'WHERE ';
        foreach ($data as $key => $value) {
            if ($key == 'workshop_name' && $key == 'workshop_user_id' && $key == 'workshop_date' && $key == 'workshop_id') {
                $condition .= " " . $key . " = :" . $key . " OR";
            } else {
                unset($data[$key]);
            }
        }

        $condition = rtrim($condition, 'OR');
        return array($condition, $data);
    }

}
