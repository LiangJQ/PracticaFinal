<?php

/*
 * Author: Liang Shan Ji
 */

class Dashboard extends Controller {

    function __construct() {
        parent::__construct();

        $loggedIn = Session::get('is_user_logged_in');

        if ($loggedIn == false) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

    function index() {
        $this->view->personalInformation = $this->model->personalInformation();
        $this->view->render('dashboard/index');
    }

}