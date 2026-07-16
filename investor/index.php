<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkInvestorLogin();

$title = 'Dashboard';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$inv_id = $_SESSION['investor_id'];
$inv_balance = getInvestorBalance($inv_id);
$profit_balance = getInvestorProfitBalance($inv_id);
$total_profit = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'profit'")[0]['tot'] ?? 0;
$total_withdraw = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'profit_withdraw'")[0]['tot'] ?? 0;
?>

<h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome, <?= htmlspecialchars($inv_data['name']) ?>!</h1>
<p class="text-gray-500 mb-6">Here's your financial summary</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
        <p>Investment Balance</p>
        <h3><?= showMoney($inv_balance) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
        <p>Available Profit</p>
        <h3><?= showMoney($profit_balance) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #06b6d4);">
        <p>Total Profit Earned</p>
        <h3><?= showMoney($total_profit) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
        <p>Total Withdrawn</p>
        <h3><?= showMoney($total_withdraw) ?></h3>
    </div>
</div>

<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900">Recent Transactions</h5>
    </div>
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Type</th><th>Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $txns = $db->getFull('investor_ledger', '*', " AND investor_id = $inv_id ORDER BY date DESC, id DESC LIMIT 20");
                foreach ($txns as $t):
                    $tb = '';
                    switch($t['type']) {
                        case 'deposit': $tb = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Deposit</span>'; break;
                        case 'investment_withdraw': $tb = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Invest Withdraw</span>'; break;
                        case 'profit': $tb = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-700">Profit</span>'; break;
                        case 'profit_withdraw': $tb = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Profit Withdraw</span>'; break;
                    }
                ?>
                <tr>
                    <td><?= $t['date'] ?></td>
                    <td><?= $tb ?></td>
                    <td><?= showMoney($t['amount']) ?></td>
                    <td><?= htmlspecialchars($t['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
