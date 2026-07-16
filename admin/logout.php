<?php
session_start();
session_destroy();
header('Location: ' . domain . 'admin/login.php');
exit;
