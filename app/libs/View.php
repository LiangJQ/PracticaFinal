<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Provides the methods all views will have
 */
class View {

    /**
     * includes (=shows) the view. this is done from the controller. 
     * 
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     */
    public function renderOnePage($filename) {
        require VIEWS_PATH . 'body/' . $filename . '.php';
    }

    /**
     * includes (=shows) the view of header footer and the $filename passed. this is done from the controller. 
     * 
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     */
    public function render($filename) {
        require VIEWS_PATH . 'header/header.php';
        require VIEWS_PATH . 'body/' . $filename . '.php';
        require VIEWS_PATH . 'footer/footer.php';
    }

    /**
     * includes (=shows) the view of header footer and an array of $filename passed. this is done from the controller. 
     * 
     * @param string $filenameArray Path of the to-be-rendered view, usually folder/file(.php)
     */
    public function renderArray($filenameArray) {
        require VIEWS_PATH . 'header/header.php';
        foreach ($filenameArray as $key => $value) {
            require VIEWS_PATH . 'body/' . $value . '.php';
        }
        require VIEWS_PATH . 'footer/footer.php';
    }

}
