<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Withdrawals';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $t = $db->getAll('investor_ledger', " AND id = $id AND type IN ('profit_withdraw','investment_withdraw')");
    if ($t) {
        $db->edit("DELETE FROM investor_ledger WHERE id = $id");
    }
    echo "<script>Swal.fire('Deleted!','Withdrawal removed.','success').then(()=>location='withdraw.php')</script>";
}
?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Withdrawals</h1>
    <div class="flex gap-2">
        <a href="<?= domain ?>admin/withdraw_add.php?type=profit" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
            <i class="bi bi-plus-lg"></i> Profit Withdraw
        </a>
        <a href="<?= domain ?>admin/withdraw_add.php?type=investment" class="inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
            <i class="bi bi-plus-lg"></i> Investment Withdraw
        </a>
    </div>
</div>

<div class="content-card">
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr>
                    <th>#</th><th>Date</th><th>Investor</th><th>Type</th><th>Amount</th><th>Remarks</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $wds = $db->getFull('investor_ledger', '*', " AND type IN ('profit_withdraw','investment_withdraw') ORDER BY date DESC, id DESC");
                foreach ($wds as $w):
                    $label = $w['type'] == 'profit_withdraw'
                        ? '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700"><i class="bi bi-wallet2"></i> Profit</span>'
                        : '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700"><i class="bi bi-bank"></i> Investment</span>';
                ?>
                <tr>
                    <td><?= $w['id'] ?></td>
                    <td><?= $w['date'] ?></td>
                    <td><?= getInvestorName($w['investor_id']) ?></td>
                    <td><?= $label ?></td>
                    <td><?= showMoney($w['amount']) ?></td>
                    <td><?= htmlspecialchars($w['remarks']) ?></td>
                    <td>
                        <a href="withdraw.php?delete=<?= $w['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" onclick="return confirm('Delete this withdrawal?')">
                            <i class="bi bi-trash text-sm"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
