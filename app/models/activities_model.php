<?php

/*
 * Author: Liang Shan Ji
 */

class Activities_Model extends Model {

    function __construct() {
        parent::__construct();
    }

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
        $condition = "workshop_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL ".LIMIT_DAY_VIEW ." DAY AND workshop_authorize = :workshop_authorize ORDER BY workshop_date ASC";
        $bindValues = array(
            'workshop_authorize' => 'Y'
        );
        return $this->db->select('workshop', $attr, $condition, $bindValues);
    }

}
