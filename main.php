<?php
ob_start();
session_start();
define('db','sakib');
define('user','root');
define('pass','');
define('domain', 'http://localhost/investor_sakib/');

spl_autoload_register(function($clsname){
    include_once 'config/'.$clsname.'.php';
});
$db = new Functions();
