<?php

/*
 * Author: Liang Shan Ji
 */

class View {

    function __construct() {
    }

    public function render($filename, $noInclude = false) {
        if ($noInclude == true) {
            require VIEWS_PATH . 'body/' . $filename . '.php';
        }
        require VIEWS_PATH . 'header/header.php';
        require VIEWS_PATH . 'body/' . $filename . '.php';
        require VIEWS_PATH . 'footer/footer.php';
    }

}
