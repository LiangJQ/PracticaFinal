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
        $this->view->render('invitation/index');
    }

}
