<?php

/* 
 * Author: Liang Shan Ji
 */

/*
 * Constants
 */
define('USER_LOGGED_IN', true);

define('ROLE_USER', 'user');
define('ROLE_ADMIN', 'admin');
define('ROLE_OWNER', 'owner');

define('REDIRECT_URL', 'redirect/url/');

define('PASSWORD_UPDATE_SUCCESFUL', 'Your password has been updated');
define('PASSWORD_NOT_MATCHING', 'Password does not match the confirm password');
define('PASSWORD_WRONG_CURRENT_PASSWORD', 'Incorrect current password');

/*
 * Database configuration
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'practica_final');
define('DB_USER', 'tdw');
define('DB_PASS', 'tdwwdt');

/*
 * Database constants
 */
define('LIMIT_DAY_VIEW', 15);

/*
 * Paths
 */
// Url path
define('URL', 'http://localhost/PracticaFinal/');

// App folder paths
define('CONTROLLERS_PATH', 'app/controllers/');
define('LIBS_PATH', 'app/libs/');
define('MODELS_PATH', 'app/models/');
define('VIEWS_PATH', 'app/views/');
define('CONFIG_PATH', 'app/config/');
define('UTILS_PATH', 'app/utils/');


// Public folder paths
define('CSS_PATH', 'public/css/');
define('IMG_PATH', 'public/img/');
define('JS_PATH', 'public/js/');