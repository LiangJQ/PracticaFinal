<?php

/*
 * Author: Liang Shan Ji
 */

class Invitation extends Controller {

    function __construct() {
        parent::__construct();

        Auth::checkLoggedIn();
    }

    function index() {
        $list = $this->model->listActivitiesInvited();
        if (!empty($list)) {
            is_array($list) ? $this->view->listActivitiesInvited = $list : $this->view->listActivitiesInvited = array($list);
        } else {
            $this->view->listActivitiesInvited = $list;
        }
        $this->view->render('invitation/index');
    }

}
