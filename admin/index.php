<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Dashboard';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$total_investors = getTotalInvestors();
$active_investors = getActiveInvestors();
$total_investment = getTotalInvestmentBalance();
$total_profit_given = getTotalProfitGiven();
$total_profit_withdraw = getTotalProfitWithdraw();
$total_investment_withdraw = getTotalInvestmentWithdraw();
$admin_income = getAdminIncome();
$payable_profit = getInvestorPayableProfit();
$total_deposits = getTotalDeposits();
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-8">
    <div class="stat-card card-gradient-1">
        <p>Total Investors</p>
        <h3><?= $total_investors ?></h3>
    </div>
    <div class="stat-card card-gradient-2">
        <p>Active Investors</p>
        <h3><?= $active_investors ?></h3>
    </div>
    <div class="stat-card card-gradient-3">
        <p>Total Deposits</p>
        <h3><?= showMoney($total_deposits) ?></h3>
    </div>
    <div class="stat-card card-gradient-6">
        <p>Investment Balance</p>
        <h3><?= showMoney($total_investment) ?></h3>
    </div>
    <div class="stat-card card-gradient-4">
        <p>Total Profit Given</p>
        <h3><?= showMoney($total_profit_given) ?></h3>
    </div>
    <div class="stat-card card-gradient-5">
        <p>Profit Withdrawn</p>
        <h3><?= showMoney($total_profit_withdraw) ?></h3>
    </div>
    <div class="stat-card card-gradient-1">
        <p>Investment Withdrawn</p>
        <h3><?= showMoney($total_investment_withdraw) ?></h3>
    </div>
    <div class="stat-card card-gradient-2">
        <p>Payable Profit</p>
        <h3><?= showMoney($payable_profit) ?></h3>
    </div>
    <div class="stat-card card-gradient-3">
        <p>Admin Income</p>
        <h3><?= showMoney($admin_income) ?></h3>
    </div>
</div>

<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900 m-0">Recent Profit Entries</h5>
    </div>
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Investor</th>
                    <th>Gross Profit</th>
                    <th>Admin Amt</th>
                    <th>Investor Amt</th>
                </tr>
            </thead>
            <tbody>
                <?php $profits = $db->getFull('daily_profit', '*', ' ORDER BY id DESC LIMIT 20');
                foreach ($profits as $p): ?>
                <tr>
                    <td><?= $p['date'] ?></td>
                    <td><?= getInvestorName($p['investor_id']) ?></td>
                    <td><?= showMoney($p['gross_profit']) ?></td>
                    <td><?= showMoney($p['admin_amount']) ?></td>
                    <td><?= showMoney($p['investor_amount']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
