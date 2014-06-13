<?php

/*
 * Author: Liang Shan Ji
 */

class Activities extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $list = $this->model->listActivities();
        if (!empty($list)) {
            is_array($list) ? $this->view->listActivities = $list : $this->view->listActivities = array($list);
        } else {
            $this->view->listActivities = $list;
        }
        $this->view->render('activities/index');
    }
}
