<?php

/*
 * Author: Liang Shan Ji
 */

class View {

    function __construct() {
        
    }

    public function renderOnePage($filename) {
            require VIEWS_PATH . 'body/' . $filename . '.php';
    }

    public function render($filename) {
        require VIEWS_PATH . 'header/header.php';
        require VIEWS_PATH . 'body/' . $filename . '.php';
        require VIEWS_PATH . 'footer/footer.php';
    }

    public function renderArray($filenameArray, $noInclude = false) {
        if ($noInclude == true) {
            foreach ($filenameArray as $key => $value) {
                require VIEWS_PATH . 'body/' . $value . '.php';
            }
        }
        require VIEWS_PATH . 'header/header.php';
        foreach ($filenameArray as $key => $value) {
            require VIEWS_PATH . 'body/' . $value . '.php';
        }
        require VIEWS_PATH . 'footer/footer.php';
    }

}
