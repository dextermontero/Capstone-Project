<?php
date_default_timezone_set('Asia/Manila');
$root = 'H:/root/home/kaizbenoya-002/www/Embat842022';
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define ('SITE_ROOT', $root);

defined('LIB_PATH') ? null : define ('LIB_PATH',SITE_ROOT.DS.'include');

require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."database.php");

?>