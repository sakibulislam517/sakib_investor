<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$investor_id = intval($_GET['investor_id'] ?? 0);
$type = $_GET['type'] ?? 'profit';

if ($investor_id) {
    if ($type == 'profit') {
        echo number_format(getInvestorProfitBalance($investor_id), 2);
    } else {
        echo number_format(getInvestorBalance($investor_id), 2);
    }
}
