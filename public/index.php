<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Define application environment
defined('CONFIG_ENV') 
    || define('CONFIG_ENV', (getenv('CONFIG_ENV') ? getenv('CONFIG_ENV') : 'application'));

$config = 'config/' . CONFIG_ENV . '.config.php';

if(!file_exists($config)) {
    $config = 'config/application.config.php';
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require $config)->run();
