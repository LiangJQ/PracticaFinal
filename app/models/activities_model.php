<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Handles activities
 */
class Activities_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Fetches all activities rows of `workshop` table where have been authorized
     * sorted by date
     * @return array    : array of activities object
     */
    public function listActivities() {

        // get activities data
        $attr = array('workshop_id',
            'workshop_name',
            'workshop_description',
            'workshop_url_web',
            'workshop_url_file',
            'workshop_date',
            'workshop_authorize'
        );
        $condition = "WHERE workshop_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL " . LIMIT_DAY_VIEW . " DAY "
                . "AND workshop_authorize = :workshop_authorize ORDER BY workshop_date ASC";
        $conditionArrayValues = array(
            'workshop_authorize' => 'Y'
        );
        return $this->db->select('workshop', $attr, $condition, $conditionArrayValues);
    }

}
