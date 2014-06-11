<?php

/*
 * Author: Liang Shan Ji
 */

class App {

    private $_url = null;
    private $_controller = null;

    /**
     * Starts App
     */
    public function init() {
        // Sets private $_url
        $this->_getUrl();

        // Load the default controller if no URL is set
        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
        }
        // (Possible) Redirect webiste
        $this->_redirectWebsite();

        // Load the available controller
        $this->_loadAvailableController();


        // Calls methods of controller
        $this->_callControllerMethod();
    }

    /**
     * Display an error page
     * 
     * @return boolean
     */
    private function _error() {
        require CONTROLLERS_PATH . 'error.php';
        $this->_controller = new Error();
        $this->_controller->index();
        exit();
    }

    /**
     * Gets $_GET from 'url' and sets it to $_url
     */
    private function _getUrl() {
        $urlAll = filter_input(INPUT_GET, 'url') ? filter_input(INPUT_GET, 'url') : null;
        $this->_url = explode('/', rtrim($urlAll, '/'));
    }

    /**
     * Loads if there is no $_GET parameter passed
     */
    private function _loadDefaultController() {
        require CONTROLLERS_PATH . 'index.php';
        $this->_controller = new Index();
        $this->_controller->index();
        exit();
    }

    /**
     * Loads if there ARE $_GET parameters passed
     */
    private function _loadAvailableController() {
        $file = CONTROLLERS_PATH . $this->_url[0] . '.php';

        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0]);
        } else {
            $this->_error();
        }
    }

    /**
     * Calls method of the controller if the method is passed in $_GET parameter
     * 
     * Eg. http://localhost/{root folder}/{controller}/{method}/{(parameter)}/{(parameter)}/{(parameter)}
     * 
     * $this->_url[0] = controller
     * $this->_url[1] = method
     * $this->_url[2] = parameter
     * $this->_url[3] = parameter
     * $this->_url[4] = parameter
     * 
     * @return boolean
     */
    private function _callControllerMethod() {

        $length = count($this->_url);

        if ($length > 1 && !method_exists($this->_controller, $this->_url[1])) {
            $this->_error();
        }

        switch ($length) {
            case 5:
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            case 4:
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            case 3:
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            case 2:
                $this->_controller->{$this->_url[1]}();
                break;
            default:
                $this->_controller->index();
                break;
        }
    }

    /**
     * Redirect website 
     * 
     * Eg. http://localhost/{root folder}/{controller}/{url}
     * 
     * $this->_url[0] = controller
     * $this->_url[1] = url
     * 
     */
    private function _redirectWebsite() {

        $length = count($this->_url);

        if ($length > 0 && $this->_url[0] == 'redirect') {
            $urlAll = filter_input(INPUT_GET, 'url');
            $urlWeb = str_replace(':/', '://', str_replace(REDIRECT_URL, '', strstr($urlAll, REDIRECT_URL)));
            header('Location: ' . $urlWeb);
            exit();
        }
    }

}
