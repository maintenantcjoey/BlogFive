<?php

require 'vendor/autoload.php';
require_once 'config/conf.php';

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/routes.php';