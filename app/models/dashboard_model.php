<?php

/*
 * Author: Liang Shan Ji
 */

class Dashboard_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function personalInformation() {
        // get user's data
        $sth = $this->db->prepare("SELECT user_id,
                                          user_name,
                                          user_email,
                                          user_role
                                   FROM   users
                                   WHERE  (user_id = :user_id)");
        $sth->execute(array(':user_id' => Session::get('user_id')));

        return $sth->fetch();
    }

}
