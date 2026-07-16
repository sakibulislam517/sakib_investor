<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkInvestorLogin();

$title = 'Profit History';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$inv_id = $_SESSION['investor_id'];
$profit_balance = getInvestorProfitBalance($inv_id);
$inv_share = 100 - ($inv_data['profit_percent'] ?? 0);
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Profit History</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
        <p>Available Profit Balance</p>
        <h3><?= showMoney($profit_balance) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #06b6d4);">
        <p>Your Profit Share</p>
        <h3><?= $inv_share ?>%</h3>
    </div>
</div>

<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900">Daily Profit Entries</h5>
    </div>
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Gross Profit</th><th>Your Share</th><th>Your Amount</th><th>Admin Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $profits = $db->getFull('daily_profit', '*', " AND investor_id = $inv_id ORDER BY date DESC, id DESC");
                foreach ($profits as $p):
                    $i_pct = 100 - $p['admin_percent'];
                ?>
                <tr>
                    <td><?= $p['date'] ?></td>
                    <td><?= showMoney($p['gross_profit']) ?></td>
                    <td><?= $i_pct ?>%</td>
                    <td class="font-semibold text-emerald-600"><?= showMoney($p['investor_amount']) ?></td>
                    <td><?= showMoney($p['admin_amount']) ?></td>
                    <td><?= htmlspecialchars($p['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
