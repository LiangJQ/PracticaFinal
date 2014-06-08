<?php

/*
 * Author: Liang Shan Ji
 */

class Manager extends Controller {

    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
    }

    function index() {
        $this->page();
    }

    function page($page = 'index') {
        $array = array(
            1 => "manager/menuAction",
            2 => "manager/$page"
        );
        $this->view->renderArray($array);
    }

}
