<?php
session_start();

function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function isInvestorLoggedIn() {
    return isset($_SESSION['investor_id']);
}

function checkAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: ' . domain . 'admin/login.php');
        exit;
    }
}

function checkInvestorLogin() {
    if (!isInvestorLoggedIn()) {
        header('Location: ' . domain . 'investor/login.php');
        exit;
    }
}

function adminLogin($username, $password) {
    global $db;
    $data = $db->getAll('admin', " AND username = '$username'");
    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['admin_id'] = $data['id'];
        $_SESSION['admin_user'] = $data['username'];
        return true;
    }
    return false;
}

function investorLogin($username, $password) {
    global $db;
    $data = $db->getAll('investors', " AND username = '$username' AND status = 1");
    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['investor_id'] = $data['id'];
        $_SESSION['investor_name'] = $data['name'];
        return true;
    }
    return false;
}
