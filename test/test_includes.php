<?php

$dir = dirname(__FILE__);
$config_path = $dir.'/config.php';
if (file_exists($config_path) === true) {
    require_once $config_path;
} else {

}

require_once $dir.'/../src/Tiket.php';
