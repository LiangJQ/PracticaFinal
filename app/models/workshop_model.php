<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Handles user's workshop/activity
 */
class Workshop_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Fetches the activity with passed $userId from database
     * @param int $userId   :  activity int
     * @return object   : activity object
     */
    public function getUserActivity($userId) {
        $condition = "WHERE workshop_user_id = $userId";
        return $this->db->select('workshop', array('*'), $condition);
    }

    /**
     * Fetches all dates that have been reserved for activities from database
     * Range 30 days
     * @return array    : array of dates
     */
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

    /**
     * Creates an activity with passed data.
     * Insert into database
     * @param array $data   : activity data
     */
    public function createActivity($data) {
        $this->db->insert('workshop', $data);
    }

    /**
     * Saves activity with passed data
     * Update database
     * @param array $data   :  activity data
     * @param int $id   : activity id
     */
    public function editActivitySave($data, $id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->update('workshop', $data, $condition, $conditionArrayValues);
    }

    /**
     * Deletes activity from database
     * @param int $id   : activity id
     */
    public function deleteActivity($id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        $this->db->delete('workshop', $condition, $conditionArrayValues);
    }

    /**
     * Confirms activity to be authorized
     * Send request to admin
     * Update database
     * @param int $id   : activity id
     */
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

    /**
     * Fetches the activity with passed id from database
     * @param int $id   : activity id
     * @return object   : activity object
     */
    public function singleActivity($id) {
        $condition = "WHERE workshop_id = :workshop_id";
        $conditionArrayValues = array(
            'workshop_id' => $id
        );
        return $this->db->select('workshop', array('*'), $condition, $conditionArrayValues);
    }

    /**
     * Fetches the activity with passed id from database
     * @param array $data   :  activity data
     * @return object   : activity object
     */
    public function singleActivityByData($data) {
        $condition = $this->dataFormatForActivityCheckExist($data);
        return $this->db->select('workshop', array('*'), $condition[0], $condition[1]);
    }

    /**
     * Return the number of rows searched with passed data from database
     * @param array $data   : activity data
     * @return int  : number of rows
     */
    public function activityCheckExist($data) {
        $condition = $this->dataFormatForActivityCheckExist($data);
        return $this->db->rowCountNumber('workshop', array('*'), $condition[0], $condition[1]);
    }

    /**
     * Fetches all rows of the area of the activity, contains userId from database
     * @return array    : array of object, userId assigned to activity areaId
     */
    public function listUsersInvited() {
        $userActivityId = Session::get('userActivity');
        $condition = "WHERE area_id = $userActivityId ";
        return $this->db->select('area', array('*'), $condition);
    }

    /**
     * Fetches all users from database sorted by surname and name
     * @return array    : array of users object
     */
    public function listUsersToInvite() {
        $attr = array('*');
        $condition = "ORDER BY user_surname, user_name ASC";
        return $this->db->select('users', $attr, $condition);
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
     * Saves invited users with assigned table and seat
     * Updates database
     * @param array $array  : array containing table, seat and userId
     */
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

    /**
     * Updates all table and seat of user's area activity to 0.
     * Updates database
     */
    public function emptyUserDistribution() {
        $userActivityId = Session::get('userActivity');
        $data = array(
            'area_table' => 0,
            'area_seat' => 0
        );
        $this->db->update('area', $data, "WHERE area_id = $userActivityId");
    }

    /**
     * Updates table and seat to 0
     * Updates database
     * @param int $table    : table number
     * @param int $seat     :seat number
     */
    public function toZeroSeatRow($table, $seat) {
        $userActivityId = Session::get('userActivity');
        $data = array(
            'area_table' => 0,
            'area_seat' => 0
        );
        $this->db->update('area', $data, "WHERE area_table = $table AND area_seat = $seat AND area_id = $userActivityId");
    }

    /**
     * Deletes user from manager user's activity area
     * Updates database
     * @param int $userId   : userId
     */
    public function deleteUserRow($userId) {
        $userActivityId = Session::get('userActivity');
        $this->db->delete('area', "WHERE area_user_id = $userId AND area_id = $userActivityId");
    }

    /**
     * Deletes users with no table and seat assigned from manager user's activity area if activity is 
     * confirmed/requested to be authorized
     * Updates database
     */
    public function emptyInvitedUsersNoSeat() {
        $userActivityId = Session::get('userActivity');
        $this->db->delete('area', "WHERE area_table = 0 AND area_seat = 0 AND area_id = $userActivityId");
    }

    /**
     * Updates invited user's table and seat to 0
     * Updates database
     * @param int $id   : userId
     */
    public function toZeroUserRow($id) {
        $userActivityId = Session::get('userActivity');
        $data = array(
            'area_table' => 0,
            'area_seat' => 0
        );
        $this->db->update('area', $data, "WHERE area_user_id = $id AND area_id = $userActivityId");
    }

    /**
     * Inserts users in area, which make them guest to the activity
     * Updates database
     * @param int $userId   : userId
     */
    public function insertUserRow($userId) {
        $data = array(
            'area_id' => Session::get('userActivity'),
            'area_user_id' => $userId
        );
        $this->db->insert('area', $data);
    }

    /**
     * Return the number of rows searched with passed data from database
     * Check if table and seat are already taken
     * @param array $data   : area activity data
     * @return int  : number of rows
     */
    public function areaWorkshopCheckSeatExist($data) {
        $condition = $this->dataFormatForAreaWorkshopCheckSeatExist($data);
        return $this->db->rowCountNumber('area', array('*'), $condition[0], $condition[1]);
    }

    /**
     * Return the number of rows searched with passed data from database
     * Check if user exist in area activity
     * @param int $userId   : invited user's id
     * @return int  : number of rows
     */
    public function areaWorkshopCheckUserExistSingle($userId) {
        $userActivityId = Session::get('userActivity');
        $array = array(
            'area_id' => $userActivityId,
            'area_user_id' => $userId
        );
        $condition = "WHERE area_id = :area_id AND area_user_id = :area_user_id";
        return $this->db->rowCountNumber('area', array('*'), $condition, $array);
    }

    /**
     * Return the number of rows searched with passed data from database
     * Check if user is in area activity
     * @param array $data   : area activity data
     * @return int  : number of rows
     */
    public function areaWorkshopCheckUserExist($data) {
        $condition = $this->dataFormatForAreaWorkshopCheckUserExist($data);
        return $this->db->rowCountNumber('area', array('*'), $condition[0], $condition[1]);
    }

    /**
     * Reorganizes data and create a condition string for checking
     * if an table and seat already been taken in area activity.
     * @param array $data   : area data
     * @return array        : array[0] = condition, array[1] = activityd data
     */
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

    /**
     * Reorganizes data and create a condition string for checking
     * if an user alredy exist in area activity.
     * @param array $data   : area data
     * @return array        : array[0] = condition, array[1] = activityd data
     */
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

    /**
     * Reorganizes data and create a condition string for checking
     * if an area activity exists.
     * @param array $data   : activity data
     * @return array        : array[0] = condition, array[1] = activityd data
     */
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
