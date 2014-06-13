<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Shows a list of activity that the user has been invited.
 */
class Invitation extends Controller {

    /**
     * Checks if user is logged in
     * Exit to home page if user is not logged in.
     */
    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
    }

    /**
     * Shows a list of activities with the title of activity, its date, its manager name, the table and seat where the user has been asigned.
     */
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
