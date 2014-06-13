<?php

/*
 * Author: Liang Shan Ji
 */

class Invitation_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function listActivitiesInvited() {
        
        $attr = array(
            'user_name',
            'user_surname',
            'workshop_name',
            'workshop_date',
            'area_table',
            'area_seat'
        );
        $condition = " INNER JOIN `area` ON  workshop_id = area_id INNER JOIN `users` ON workshop_user_id = user_id WHERE workshop_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL " . LIMIT_DAY_VIEW . " DAY "
                . "AND workshop_authorize = :workshop_authorize AND area_user_id = :area_user_id ORDER BY workshop_date ASC";
        $conditionArrayValues = array(
            'workshop_authorize' => 'Y',
            'area_user_id' => Session::get('user_id')
        );
        return $this->db->select('workshop', $attr, $condition, $conditionArrayValues);
    }

}
