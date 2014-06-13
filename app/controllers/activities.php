<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Shows activities that have been authorized
 */
class Activities extends Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * Base page. 
     * Passing to view a list of authorized activities.
     */
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
