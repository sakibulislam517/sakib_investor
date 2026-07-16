<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Investors';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db->edit("DELETE FROM investors WHERE id = $id");
    echo "<script>Swal.fire('Deleted!','Investor removed.','success').then(()=>location='investors.php')</script>";
}
?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Investors</h1>
    <a href="<?= domain ?>admin/investor_add.php" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
        <i class="bi bi-plus-lg"></i> Add Investor
    </a>
</div>

<div class="content-card">
    <div class="p-6">
        <table class="datatable w-full">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Admin Share</th>
                    <th>Inv. Balance</th>
                    <th>Profit Bal.</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $investors = $db->getFull('investors', '*', ' ORDER BY name ASC');
                foreach ($investors as $i):
                    $inv_bal = getInvestorBalance($i['id']);
                    $prof_bal = getInvestorProfitBalance($i['id']);
                ?>
                <tr>
                    <td><?= $i['id'] ?></td>
                    <td>
                        <a href="<?= domain ?>admin/investor_profile.php?id=<?= $i['id'] ?>" class="investor-balance-link">
                            <?= htmlspecialchars($i['name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($i['phone']) ?></td>
                    <td><?= htmlspecialchars($i['email']) ?></td>
                    <td><?= htmlspecialchars($i['username']) ?></td>
                    <td><?= $i['profit_percent'] ?>%</td>
                    <td><?= showMoney($inv_bal) ?></td>
                    <td><?= showMoney($prof_bal) ?></td>
                    <td><?= getStatusBadge($i['status']) ?></td>
                    <td>
                        <div class="flex gap-1">
                            <a href="<?= domain ?>admin/investor_profile.php?id=<?= $i['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition" title="View Profile">
                                <i class="bi bi-eye text-sm"></i>
                            </a>
                            <a href="<?= domain ?>admin/investor_edit.php?id=<?= $i['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition" title="Edit">
                                <i class="bi bi-pencil text-sm"></i>
                            </a>
                            <a href="investors.php?delete=<?= $i['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Delete" onclick="return confirm('Delete this investor?')">
                                <i class="bi bi-trash text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
