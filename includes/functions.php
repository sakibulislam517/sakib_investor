<?php
/**
 * Helper functions for Investor Profit Management System
 */

function getSettings() {
    global $db;
    $data = $db->getdata("SELECT * FROM settings WHERE id = 1");
    return $data ? $data[0] : [];
}

function getCompanyName() {
    $s = getSettings();
    return $s['company_name'] ?? 'Investor Profit Management';
}

function getCurrency() {
    $s = getSettings();
    return $s['currency'] ?? 'USD';
}

function getCurrencySymbol() {
    $cur = getCurrency();
    $symbols = ['USD' => '$', 'EUR' => '€', 'GBP' => '£', 'BDT' => '৳', 'INR' => '₹'];
    return $symbols[$cur] ?? '$';
}

function formatMoney($amount) {
    return number_format($amount, 2);
}

function showMoney($amount) {
    return getCurrencySymbol() . ' ' . number_format($amount, 2);
}

function getInvestorName($id, $link = true) {
    global $db;
    $d = $db->getAll('investors', " AND id = $id");
    if (!$d) return 'Unknown';
    $name = htmlspecialchars($d['name']);
    if ($link) {
        return '<a href="' . domain . 'admin/investor_profile.php?id=' . $id . '" class="text-decoration-none fw-medium">' . $name . '</a>';
    }
    return $name;
}

function getInvestorBalance($investor_id) {
    global $db;
    $r = $db->getdata("SELECT
        COALESCE(SUM(CASE WHEN type = 'deposit' THEN amount ELSE 0 END), 0) AS deposit,
        COALESCE(SUM(CASE WHEN type = 'investment_withdraw' THEN amount ELSE 0 END), 0) AS withdraw
        FROM investor_ledger WHERE investor_id = $investor_id");

    $deposit = floatval($r[0]['deposit'] ?? 0);
    $withdraw = floatval($r[0]['withdraw'] ?? 0);
    return $deposit - $withdraw;
}

function getInvestorProfitBalance($investor_id) {
    global $db;
    $r = $db->getdata("SELECT
        COALESCE(SUM(CASE WHEN type = 'profit' THEN amount ELSE 0 END), 0) AS profit,
        COALESCE(SUM(CASE WHEN type = 'profit_withdraw' THEN amount ELSE 0 END), 0) AS withdraw
        FROM investor_ledger WHERE investor_id = $investor_id");

    $profit = floatval($r[0]['profit'] ?? 0);
    $withdraw = floatval($r[0]['withdraw'] ?? 0);
    return $profit - $withdraw;
}

function getTotalInvestors() {
    global $db;
    return $db->row_count("SELECT id FROM investors");
}

function getActiveInvestors() {
    global $db;
    return $db->row_count("SELECT id FROM investors WHERE status = 1");
}

function getTotalInvestmentBalance() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'deposit'");
    $deposit = $r ? floatval($r[0]['tot']) : 0;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'investment_withdraw'");
    $withdraw = $r ? floatval($r[0]['tot']) : 0;
    return $deposit - $withdraw;
}

function getTotalProfitGiven() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'profit'");
    return $r ? floatval($r[0]['tot']) : 0;
}

function getTotalProfitWithdraw() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'profit_withdraw'");
    return $r ? floatval($r[0]['tot']) : 0;
}

function getTotalInvestmentWithdraw() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'investment_withdraw'");
    return $r ? floatval($r[0]['tot']) : 0;
}

function getAdminIncome() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(admin_amount),0) as tot FROM daily_profit");
    return $r ? floatval($r[0]['tot']) : 0;
}

function getInvestorPayableProfit() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'profit'");
    $profit = $r ? floatval($r[0]['tot']) : 0;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'profit_withdraw'");
    $withdraw = $r ? floatval($r[0]['tot']) : 0;
    return $profit - $withdraw;
}

function getTotalDeposits() {
    global $db;
    $r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE type = 'deposit'");
    return $r ? floatval($r[0]['tot']) : 0;
}

function getStatusBadge($status) {
    return $status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
}
