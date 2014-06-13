<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Base model. Other models extend this class
 * 
 * When a model is created, create a database connection.
 */
class Model {

    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

}
