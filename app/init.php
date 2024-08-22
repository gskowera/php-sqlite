<?php

define('ROOT_DIR', __DIR__);
define('CONFIG_DIR', ROOT_DIR . '/config');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('PUBLIC_URL', 'http://localhost');
define('VIEWS_DIR', ROOT_DIR . '/views');

require ROOT_DIR . '/src/autoloader.php';

// Initialize database connection
$db = App\Database::instance();
