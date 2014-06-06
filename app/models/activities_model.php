<?php

/*
 * Author: Liang Shan Ji
 */

class Activities_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function listActivities() {
        
        $sth = $this->db->prepare("SELECT workshop_id,
                                          workshop_name,
                                          workshop_description,
                                          workshop_url_web,
                                          workshop_url_file,
                                          workshop_date
                                   FROM   workshop
                                   WHERE  (workshop_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 15 DAY)");
        $sth->execute();
        
        return $sth->fetchAll();
        
    }


}
