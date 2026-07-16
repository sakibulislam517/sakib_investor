<?php
session_start();
session_destroy();
header('Location: ' . domain . 'investor/login.php');
exit;
