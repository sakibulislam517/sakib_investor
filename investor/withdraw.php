<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkInvestorLogin();

$title = 'Withdraw';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$inv_id = $_SESSION['investor_id'];
$profit_balance = getInvestorProfitBalance($inv_id);
$inv_balance = getInvestorBalance($inv_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_withdraw'])) {
    $amount = floatval($_POST['amount']);
    $type = $_POST['withdraw_type'];
    $remarks = $_POST['remarks'];

    if ($type == 'profit') {
        $balance = getInvestorProfitBalance($inv_id);
        $ledger_type = 'profit_withdraw';
    } else {
        $balance = getInvestorBalance($inv_id);
        $ledger_type = 'investment_withdraw';
    }

    if ($amount <= 0) {
        echo "<script>Swal.fire('Error!','Invalid amount.','error')</script>";
    } elseif ($amount > $balance) {
        echo "<script>Swal.fire('Error!','Insufficient balance. Available: " . showMoney($balance) . "','error')</script>";
    } else {
        $date = date('Y-m-d');
        $sql = "INSERT INTO investor_ledger (investor_id, date, type, amount, remarks) VALUES ($inv_id, '$date', '$ledger_type', '$amount', '$remarks')";
        if ($db->insert($sql)) {
            echo "<script>Swal.fire('Success!','Withdrawal request submitted.','success').then(()=>location='withdraw.php')</script>";
        } else {
            echo "<script>Swal.fire('Error!','Failed.','error')</script>";
        }
    }
}
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Withdrawals</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
        <p>Available Profit</p>
        <h3><?= showMoney($profit_balance) ?></h3>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
        <p>Investment Balance</p>
        <h3><?= showMoney($inv_balance) ?></h3>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Profit Withdraw -->
    <div class="content-card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h5 class="font-semibold text-gray-900">Request Profit Withdraw</h5>
        </div>
        <div class="p-6">
            <form method="post" onsubmit="return confirm('Submit withdrawal request?')">
                <input type="hidden" name="withdraw_type" value="profit">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Amount (USD)</label>
                        <input type="number" name="amount" step="0.01" min="0" max="<?= $profit_balance ?>" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Remarks</label>
                        <input type="text" name="remarks" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition" placeholder="Withdrawal request">
                    </div>
                    <button type="submit" name="request_withdraw" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-medium py-2.5 rounded-xl transition shadow-sm">
                        <i class="bi bi-wallet2"></i> Withdraw Profit
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Investment Withdraw -->
    <div class="content-card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h5 class="font-semibold text-gray-900">Request Investment Withdraw</h5>
        </div>
        <div class="p-6">
            <form method="post" onsubmit="return confirm('Submit withdrawal request?')">
                <input type="hidden" name="withdraw_type" value="investment">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Amount (USD)</label>
                        <input type="number" name="amount" step="0.01" min="0" max="<?= $inv_balance ?>" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Remarks</label>
                        <input type="text" name="remarks" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition" placeholder="Investment withdrawal">
                    </div>
                    <button type="submit" name="request_withdraw" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-medium py-2.5 rounded-xl transition shadow-sm">
                        <i class="bi bi-bank"></i> Withdraw Investment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900">Withdraw History</h5>
    </div>
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Type</th><th>Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $wds = $db->getFull('investor_ledger', '*', " AND investor_id = $inv_id AND type IN ('profit_withdraw','investment_withdraw') ORDER BY date DESC, id DESC");
                foreach ($wds as $w):
                    $lb = $w['type'] == 'profit_withdraw'
                        ? '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Profit</span>'
                        : '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Investment</span>';
                ?>
                <tr>
                    <td><?= $w['date'] ?></td>
                    <td><?= $lb ?></td>
                    <td><?= showMoney($w['amount']) ?></td>
                    <td><?= htmlspecialchars($w['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
