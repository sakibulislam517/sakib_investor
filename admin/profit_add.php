<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Add Daily Profit';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $investor_id = intval($_POST['investor_id']);
    $date = $_POST['date'];
    $gross_profit = floatval($_POST['gross_profit']);
    $remarks = $_POST['remarks'];

    $investor = $db->getAll('investors', " AND id = $investor_id");
    if ($investor) {
        $admin_percent = $investor['profit_percent'];
        $investor_percent = 100 - $admin_percent;
        $admin_amount = round($gross_profit * $admin_percent / 100, 2);
        $investor_amount = round($gross_profit * $investor_percent / 100, 2);

        $sql = "INSERT INTO daily_profit (investor_id, date, gross_profit, admin_percent, admin_amount, investor_amount, remarks) 
                VALUES ($investor_id, '$date', '$gross_profit', '$admin_percent', '$admin_amount', '$investor_amount', '$remarks')";
        if ($db->insert($sql)) {
            $db->insert("INSERT INTO investor_ledger (investor_id, date, type, amount, remarks) 
                         VALUES ($investor_id, '$date', 'profit', '$investor_amount', 'Daily profit share')");
            echo "<script>Swal.fire('Success!','Profit entry added.','success').then(()=>location='profit.php')</script>";
        } else {
            echo "<script>Swal.fire('Error!','Failed.','error')</script>";
        }
    }
}

$investors = $db->getFull('investors', 'id, name, profit_percent', ' AND status = 1 ORDER BY name');
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= domain ?>admin/profit.php" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Add Daily Profit</h1>
</div>

<div class="content-card max-w-3xl">
    <div class="p-6">
        <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-5" id="profitForm">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Investor <span class="text-rose-500">*</span></label>
                <select name="investor_id" id="investor_id" class="select2 w-full" required>
                    <option value="">Select Investor</option>
                    <?php foreach ($investors as $inv): ?>
                    <option value="<?= $inv['id'] ?>" data-percent="<?= $inv['profit_percent'] ?>"><?= htmlspecialchars($inv['name']) ?> (Admin: <?= $inv['profit_percent'] ?>%)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Date <span class="text-rose-500">*</span></label>
                <input type="text" name="date" class="datepicker w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Gross Profit (USD) <span class="text-rose-500">*</span></label>
                <input type="number" name="gross_profit" id="gross_profit" step="0.01" min="0" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Admin Share</label>
                    <input type="text" id="admin_share_display" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500" readonly value="$0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Investor Share</label>
                    <input type="text" id="investor_share_display" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500" readonly value="$0.00">
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Remarks</label>
                <input type="text" name="remarks" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition" placeholder="e.g. Trading profit for the day">
            </div>
            <div class="md:col-span-2 flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">Save Entry</button>
                <a href="<?= domain ?>admin/profit.php" class="bg-white border border-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    function calculateShares() {
        var gross = parseFloat($('#gross_profit').val()) || 0;
        var percent = parseFloat($('#investor_id option:selected').data('percent')) || 0;
        var invPercent = 100 - percent;
        var adminAmt = (gross * percent / 100).toFixed(2);
        var invAmt = (gross * invPercent / 100).toFixed(2);
        $('#admin_share_display').val('$' + adminAmt + ' (' + percent + '%)');
        $('#investor_share_display').val('$' + invAmt + ' (' + invPercent + '%)');
    }
    $('#investor_id, #gross_profit').on('change keyup', calculateShares);
});
</script>

<?php require_once 'includes/footer.php'; ?>
