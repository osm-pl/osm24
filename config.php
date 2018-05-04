<?php

// Credentials to OpenStreetMap account for OSM24
define('USERNAME', '');
define('PASSWORD', '');

/**
 * Include a local settings file if it exists. This is the right place to keep secret informations.
 */
$local_settings = dirname(__FILE__) . '/config.local.php';
if (file_exists($local_settings)) {
  include $local_settings;
}
?>
