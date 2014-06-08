<?php

/*
 * Author: Liang Shan Ji
 */

// Load config
require 'app/config/config.php';
require UTILS_PATH . 'Auth.php';
require CONFIG_PATH . 'autoload.php';

// Load External libs
//require LIBS_PATH . 'external/rb.php';

$app = new App();
$app->init();
