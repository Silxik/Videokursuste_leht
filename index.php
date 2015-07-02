<?php

// Project constants
define('PROJECT_NAME', 'Videokursused');
define('DB_NAME', 'Videokursuste leht');
define('DEFAULT_CONTROLLER', 'videos');
define('DEBUG', false);

// Load app
require 'system/classes/Controller.php';
require 'system/classes/Auth.php';
require 'system/classes/Application.php';
$app = new Application;
