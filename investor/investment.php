<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkInvestorLogin();

$title = 'Current Investment';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$inv_id = $_SESSION['investor_id'];
$balance = getInvestorBalance($inv_id);
$r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'deposit'");
$total_deposit = $r[0]['tot'] ?? 0;
$r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'investment_withdraw'");
$total_inv_withdraw = $r[0]['tot'] ?? 0;
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Current Investment</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
        <p>Investment Balance</p>
        <h3><?= showMoney($balance) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
        <p>Total Deposited</p>
        <h3><?= showMoney($total_deposit) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #f43f5e);">
        <p>Total Withdrawn</p>
        <h3><?= showMoney($total_inv_withdraw) ?></h3>
    </div>
</div>

<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900">Investment History</h5>
    </div>
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Type</th><th>Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $txns = $db->getFull('investor_ledger', '*', " AND investor_id = $inv_id AND type IN ('deposit','investment_withdraw') ORDER BY date DESC, id DESC");
                foreach ($txns as $t):
                    $lb = $t['type'] == 'deposit'
                        ? '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Deposit</span>'
                        : '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Withdraw</span>';
                ?>
                <tr>
                    <td><?= $t['date'] ?></td>
                    <td><?= $lb ?></td>
                    <td><?= showMoney($t['amount']) ?></td>
                    <td><?= htmlspecialchars($t['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
