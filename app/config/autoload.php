<?php

/**
 * the auto-loading function, which will be called every time a file "is missing"
 */
function autoloadLibs($class) {
    // if file does not exist in LIBS_PATH folder [set it in config/paths.php]
    if (file_exists(LIBS_PATH . $class . ".php")) {
        require LIBS_PATH . $class . ".php";
    } else {
        echo ('The file ' . $class . '.php is missing in the libs folder.');
    }
}

function autoloadUtils($class) {
    // if file does not exist in UTILS_PATH folder [set it in config/paths.php]
    if (file_exists(UTILS_PATH . "Util" . $class . ".php")) {
        require UTILS_PATH . "Util" . $class . ".php";
    } else {
        echo ('The file ' . $class . '.php is missing in the utils folder.');
    }
}

function autoloadEntities($class) {
    // if file does not exist in ENTITIES_PATH folder [set it in config/paths.php]
    if (file_exists(ENTITIES_PATH . "E" . $class . ".php")) {
        require ENTITIES_PATH . "E" . $class . ".php";
    } else {
        echo ('The file ' . $class . '.php is missing in the entities folder.');
    }
}

// spl_autoload_register defines the function that is called every time a file is missing. as we created this
// function above, every time a file is needed, autoload(THENEEDEDCLASS) is called
spl_autoload_register("autoloadLibs");
spl_autoload_register("autoloadUtils");
