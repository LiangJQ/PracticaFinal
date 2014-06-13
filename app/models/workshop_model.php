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

    public function listUsersInvited() {
        $userActivityId = Session::get('userActivity');
        $condition = "WHERE area_id = $userActivityId ";
        return $this->db->select('area', array('*'), $condition);
    }

    public function listUsersToInvite() {
        $attr = array('*');
        $condition = "ORDER BY user_surname, user_name ASC";
        return $this->db->select('users', $attr, $condition);
    }

    public function singleUser($id) {
        $condition = "WHERE user_id = :user_id";
        $conditionArrayValues = array(
            'user_id' => $id
        );
        return $this->db->select('users', array('*'), $condition, $conditionArrayValues);
    }

    public function distributedUsersSave($array) {
        $data = array(
            'area_table' => $array['area_table'],
            'area_seat' => $array['area_seat']
        );
        $areaId = $array['area_id'];
        $userId = $array['area_user_id'];
        $condition = "WHERE area_user_id='$userId' AND area_id='$areaId'";

        $this->db->update('area', $data, $condition);
    }

    public function emptyUserDistribution() {
        $userActivityId = Session::get('userActivity');
        $data = array(
            'area_table' => 0,
            'area_seat' => 0
        );
        $this->db->update('area', $data, "WHERE area_id = $userActivityId");
    }

    public function toZeroSeatRow($table, $seat) {
        $userActivityId = Session::get('userActivity');
        $data = array(
            'area_table' => 0,
            'area_seat' => 0
        );
        $this->db->update('area', $data, "WHERE area_table = $table AND area_seat = $seat AND area_id = $userActivityId");
    }

    public function deleteUserRow($userId) {
        $userActivityId = Session::get('userActivity');
        $this->db->delete('area', "WHERE area_user_id = $userId AND area_id = $userActivityId");
    }

    public function emptyInvitedUsersNoSeat() {
        $userActivityId = Session::get('userActivity');
        $this->db->delete('area', "WHERE area_table = 0 AND area_seat = 0 AND area_id = $userActivityId");
    }

    public function toZeroUserRow($id) {
        $userActivityId = Session::get('userActivity');
        $data = array(
            'area_table' => 0,
            'area_seat' => 0
        );
        $this->db->update('area', $data, "WHERE area_user_id = $id AND area_id = $userActivityId");
    }

    public function insertUserRow($userId) {
        $data = array(
            'area_id' => Session::get('userActivity'),
            'area_user_id' => $userId
        );
        $this->db->insert('area', $data);
    }

    public function areaWorkshopCheckSeatExist($data) {
        $condition = $this->dataFormatForAreaWorkshopCheckSeatExist($data);
        return $this->db->rowCountNumber('area', array('*'), $condition[0], $condition[1]);
    }

    public function areaWorkshopCheckUserExistSingle($userId) {
        $userActivityId = Session::get('userActivity');
        $array = array(
            'area_id' => $userActivityId,
            'area_user_id' => $userId
        );
        $condition = "WHERE area_id = :area_id AND area_user_id = :area_user_id";
        return $this->db->rowCountNumber('area', array('*'), $condition, $array);
    }

    public function areaWorkshopCheckUserExist($data) {
        $condition = $this->dataFormatForAreaWorkshopCheckUserExist($data);
        return $this->db->rowCountNumber('area', array('*'), $condition[0], $condition[1]);
    }

    public function dataFormatForAreaWorkshopCheckSeatExist($data) {
        $userActivityId = Session::get('userActivity');
        $condition = "WHERE (";
        foreach ($data as $key => $value) {
            if ($key == 'area_user_id' || $key == 'area_id') {
                unset($data[$key]);
            } else {
                $condition .= " " . $key . " = :" . $key . " OR";
            }
        }
        $condition = rtrim($condition, 'OR');
        $condition .= ") AND area_id = $userActivityId  ";
        return array($condition, $data);
    }

    public function dataFormatForAreaWorkshopCheckUserExist($data) {
        $userActivityId = Session::get('userActivity');
        $condition = "WHERE ";
        foreach ($data as $key => $value) {
            if ($key == 'area_seat' || $key == 'area_table') {
                unset($data[$key]);
            } else {
                $condition .= " " . $key . " = :" . $key . " AND ";
            }
        }
        $condition = rtrim($condition, "AND ");
        return array($condition, $data);
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
