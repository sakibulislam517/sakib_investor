<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Daily Profit';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $p = $db->getAll('daily_profit', " AND id = $id");
    if ($p) {
        $db->edit("DELETE FROM investor_ledger WHERE investor_id = {$p['investor_id']} AND date = '{$p['date']}' AND type = 'profit' AND amount = {$p['investor_amount']}");
        $db->edit("DELETE FROM daily_profit WHERE id = $id");
    }
    echo "<script>Swal.fire('Deleted!','Profit entry removed.','success').then(()=>location='profit.php')</script>";
}
?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Daily Profit Entries</h1>
    <a href="<?= domain ?>admin/profit_add.php" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
        <i class="bi bi-plus-lg"></i> New Entry
    </a>
</div>

<div class="content-card">
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr>
                    <th>#</th><th>Date</th><th>Investor</th><th>Gross Profit</th><th>Admin %</th><th>Admin Amt</th><th>Investor Amt</th><th>Remarks</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $profits = $db->getFull('daily_profit', '*', ' ORDER BY date DESC, id DESC');
                foreach ($profits as $p):
                ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['date'] ?></td>
                    <td><?= getInvestorName($p['investor_id']) ?></td>
                    <td><?= showMoney($p['gross_profit']) ?></td>
                    <td><?= $p['admin_percent'] ?>%</td>
                    <td><?= showMoney($p['admin_amount']) ?></td>
                    <td><?= showMoney($p['investor_amount']) ?></td>
                    <td><?= htmlspecialchars($p['remarks']) ?></td>
                    <td>
                        <a href="profit.php?delete=<?= $p['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" onclick="return confirm('Delete this entry?')">
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
