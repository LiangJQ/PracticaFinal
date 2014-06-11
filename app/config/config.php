<?php

/*
 * Author: Liang Shan Ji
 */

/*
 * Constants
 */
// Check if user is logged in
define('USER_LOGGED_IN', true);

// Check user's role
define('ROLE_USER', 'user');
define('ROLE_ADMIN', 'admin');
define('ROLE_OWNER', 'owner');

define('REDIRECT_URL', 'redirect/');

// Change password related messages
define('PASSWORD_UPDATE_SUCCESFUL', 'Your password has been updated');
define('PASSWORD_NOT_MATCHING', 'Password does not match the confirm password');
define('PASSWORD_WRONG_CURRENT_PASSWORD', 'Incorrect current password');

// Create, edit and delete user related messages
define('USER_CREATED', 'User successfully created');
define('USER_CREATE_ERROR', 'User has not been created. Username or email already registered');
define('USER_EDITED', 'User successfully edited');
define('USER_EDIT_ERROR', 'User has not been edited. Username, id or email already registered by other user(s)');
define('USER_DELETED', 'User successfully deleted');

// Create, edit, delete, authorize and deny activity related messages
define('ACTIVITY_CREATED', 'Activity successfully created');
define('ACTIVITY_CREATE_ERROR', 'Activity has not been created. Activity name, date or manager id already taken');
define('ACTIVITY_EDITED', 'Activity successfully edited');
define('ACTIVITY_EDIT_ERROR', 'Activity has not been edited. Activity name, date or manager id already taken');
define('ACTIVITY_DELETED', 'Activity successfully deleted');
define('ACTIVITY_AUTHORIZED', 'Activity authorized');
define('ACTIVITY_DENIED', 'Activity denied');

// Activity creation constants (for 'request' and 'authorize')
define('REQUEST_N', 'Not sent');
define('REQUEST_Y', 'Sent');
define('AUTHORIZE_N', 'Denied');
define('AUTHORIZE_Y', 'Authorized');
define('AUTHORIZE_P', 'Pending to authorize');

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
define('MAX_LIMIT_DAY_TO_CREATE', 30);
define('START_DAY', 1);

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
define('ENTITIES_PATH', 'app/entities/');


// Public folder paths
define('CSS_PATH', 'public/css/');
define('IMG_PATH', 'public/img/');
define('JS_PATH', 'public/js/');
