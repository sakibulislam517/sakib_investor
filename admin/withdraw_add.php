<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$type = $_GET['type'] ?? 'profit';
$title = $type == 'profit' ? 'Profit Withdraw' : 'Investment Withdraw';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $investor_id = intval($_POST['investor_id']);
    $date = $_POST['date'];
    $amount = floatval($_POST['amount']);
    $remarks = $_POST['remarks'];
    $wtype = $_POST['wtype'];

    if ($wtype == 'profit') {
        $balance = getInvestorProfitBalance($investor_id);
        $type_label = 'profit_withdraw';
    } else {
        $balance = getInvestorBalance($investor_id);
        $type_label = 'investment_withdraw';
    }

    if ($amount > $balance) {
        echo "<script>Swal.fire('Error!','Insufficient balance. Available: " . showMoney($balance) . "','error')</script>";
    } else {
        $sql = "INSERT INTO investor_ledger (investor_id, date, type, amount, remarks) 
                VALUES ($investor_id, '$date', '$type_label', '$amount', '$remarks')";
        if ($db->insert($sql)) {
            echo "<script>Swal.fire('Success!','Withdrawal processed.','success').then(()=>location='withdraw.php')</script>";
        } else {
            echo "<script>Swal.fire('Error!','Failed.','error')</script>";
        }
    }
}

$investors = $db->getFull('investors', 'id, name', ' AND status = 1 ORDER BY name');
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= domain ?>admin/withdraw.php" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-gray-900"><?= $type == 'profit' ? 'Profit Withdraw' : 'Investment Withdraw' ?></h1>
</div>

<div class="content-card max-w-3xl">
    <div class="p-6">
        <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <input type="hidden" name="wtype" value="<?= $type ?>">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Investor <span class="text-rose-500">*</span></label>
                <select name="investor_id" id="inv_id" class="select2 w-full" required>
                    <option value="">Select Investor</option>
                    <?php foreach ($investors as $inv): ?>
                    <option value="<?= $inv['id'] ?>"><?= htmlspecialchars($inv['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Date <span class="text-rose-500">*</span></label>
                <input type="text" name="date" class="datepicker w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Amount (USD) <span class="text-rose-500">*</span></label>
                <input type="number" name="amount" step="0.01" min="0" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Available Balance</label>
                <input type="text" id="balance_display" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-500" readonly value="$0.00">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Remarks</label>
                <input type="text" name="remarks" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition" placeholder="e.g. Withdrawal request">
            </div>
            <div class="md:col-span-2 flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">Process Withdrawal</button>
                <a href="<?= domain ?>admin/withdraw.php" class="bg-white border border-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#inv_id').on('change', function() {
        var id = $(this).val();
        if (id) {
            $.get('ajax_balance.php?investor_id=' + id + '&type=<?= $type ?>', function(data) {
                $('#balance_display').val('$' + data);
            });
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
