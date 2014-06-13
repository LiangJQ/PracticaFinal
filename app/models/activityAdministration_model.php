<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Handles activities administration
 */
class ActivityAdministration_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Fetches all activities sorted by date from database
     * @return array    : array of activities object
     */
    public function listActivities() {
        $condition = "ORDER BY workshop_date ASC";
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
     * Return the number of rows searched with passed data from database
     * @param array $data   : activity data
     * @return int  : number of rows
     */
    public function activityCheckExist($data) {
        $condition = $this->dataFormatForActivityCheckExist($data);
        return $this->db->rowCountNumber('workshop', array('*'), $condition[0], $condition[1]);
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
     * Fetches all activities with sent requests (workshop_request == 'Y') 
     * from database 
     * @return array    : array of objects
     */
    public function listActivitiesAuthorize() {
        $condition = "WHERE workshop_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL " . LIMIT_DAY_VIEW . " DAY AND workshop_request = :workshop_request AND workshop_authorize = :workshop_authorize ORDER BY workshop_date ASC";
        $conditionArrayValues = array(
            'workshop_request' => 'Y',
            'workshop_authorize' => 'P'
        );
        return $this->db->select('workshop', array('*'), $condition, $conditionArrayValues);
    }

    /**
     * Authorizes activity
     * Update database
     * @param int $id   : activity id
     */
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

    /**
     * Denies activity
     * Update database
     * @param int $id   : activity id
     */
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

    /**
     * Reorganizes data and create a condition string for checking
     * if an activity exists.
     * @param array $data   : activity data
     * @return array        : array[0] = condition, array[1] = activityd data
     */
    private function dataFormatForActivityCheckExist($data) {
        $condition = 'WHERE ';
        foreach ($data as $key => $value) {
            if ($key == 'workshop_name' || $key == 'workshop_user_id' || $key == 'workshop_date' || $key == 'workshop_id') {
                $condition .= " " . $key . " = :" . $key . " OR";
            } else {
                unset($data[$key]);
            }
        }

        $condition = rtrim($condition, 'OR');
        return array($condition, $data);
    }

}
