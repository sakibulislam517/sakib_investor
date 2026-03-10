<?php
ob_start();
session_start();
ini_set('max_execution_time', '3000');
define('domain', 'http://localhost/naafiun/');
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = md5(time());
}
