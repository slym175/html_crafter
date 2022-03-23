<?php
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
ini_set('display_errors', 0);

require_once __DIR__ . '/vendor/autoload.php';

use Read175\HtmlCrafter\Classes\HtmlCrafter;

define('ROOT_FOLDER', __DIR__);
HtmlCrafter::init();
