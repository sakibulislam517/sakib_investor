<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Investments';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db->edit("DELETE FROM investor_ledger WHERE id = $id");
    echo "<script>Swal.fire('Deleted!','Transaction removed.','success').then(()=>location='investments.php')</script>";
}
?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Investment Transactions</h1>
    <a href="<?= domain ?>admin/investment_add.php" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
        <i class="bi bi-plus-lg"></i> New Transaction
    </a>
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
                $txns = $db->getFull('investor_ledger', '*', " AND type IN ('deposit','investment_withdraw') ORDER BY date DESC");
                foreach ($txns as $t):
                    $type_label = $t['type'] == 'deposit'
                        ? '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700"><i class="bi bi-arrow-down"></i> Deposit</span>'
                        : '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700"><i class="bi bi-arrow-up"></i> Withdraw</span>';
                ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= $t['date'] ?></td>
                    <td><?= getInvestorName($t['investor_id']) ?></td>
                    <td><?= $type_label ?></td>
                    <td><?= showMoney($t['amount']) ?></td>
                    <td><?= htmlspecialchars($t['remarks']) ?></td>
                    <td>
                        <a href="investments.php?delete=<?= $t['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" onclick="return confirm('Delete this transaction?')">
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
