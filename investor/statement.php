<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkInvestorLogin();

$title = 'Statement';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$inv_id = $_SESSION['investor_id'];

$r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'deposit'");
$total_deposit = $r[0]['tot'] ?? 0;
$r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'investment_withdraw'");
$total_inv_withdraw = $r[0]['tot'] ?? 0;
$r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'profit'");
$total_profit = $r[0]['tot'] ?? 0;
$r = $db->getdata("SELECT COALESCE(SUM(amount),0) as tot FROM investor_ledger WHERE investor_id = $inv_id AND type = 'profit_withdraw'");
$total_profit_withdraw = $r[0]['tot'] ?? 0;
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Account Statement</h1>

<!-- Investment Ledger -->
<div class="content-card mb-6">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900"><i class="bi bi-cash-stack text-indigo-500 me-2"></i> Investment</h5>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="text-left px-4 py-3 font-semibold">SL</th>
                    <th class="text-left px-4 py-3 font-semibold">Date</th>
                    <th class="text-left px-4 py-3 font-semibold">Description</th>
                    <th class="text-right px-4 py-3 font-semibold">Debit</th>
                    <th class="text-right px-4 py-3 font-semibold">Credit</th>
                    <th class="text-right px-4 py-3 font-semibold">Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php
                $txns = $db->getdata("SELECT * FROM investor_ledger WHERE investor_id = $inv_id AND type IN ('deposit','investment_withdraw') ORDER BY date ASC, id ASC");
                $bal = 0; $sl = 1;
                foreach ($txns as $t):
                    if ($t['type'] == 'investment_withdraw') {
                        $bal -= $t['amount'];
                        $credit = showMoney($t['amount']); $debit = '—';
                        $desc = 'Withdraw' . ($t['remarks'] ? ' ('.htmlspecialchars($t['remarks']).')' : '');
                    } else {
                        $bal += $t['amount'];
                        $debit = showMoney($t['amount']); $credit = '—';
                        $desc = 'Deposit' . ($t['remarks'] ? ' ('.htmlspecialchars($t['remarks']).')' : '');
                    }
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500"><?= $sl++ ?></td>
                    <td class="px-4 py-3"><?= $t['date'] ?></td>
                    <td class="px-4 py-3"><?= $desc ?></td>
                    <td class="px-4 py-3 text-right text-rose-600 font-medium"><?= $debit ?></td>
                    <td class="px-4 py-3 text-right text-emerald-600 font-medium"><?= $credit ?></td>
                    <td class="px-4 py-3 text-right font-semibold"><?= showMoney($bal) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($txns)): ?>
                <tr><td colspan="6" class="text-center text-gray-400 py-6">No investment transactions yet.</td></tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 font-semibold text-sm">
                    <td colspan="3" class="px-4 py-3 text-right text-gray-600">Total</td>
                    <td class="px-4 py-3 text-right text-rose-600"><?= showMoney($total_inv_withdraw) ?></td>
                    <td class="px-4 py-3 text-right text-emerald-600"><?= showMoney($total_deposit) ?></td>
                    <td class="px-4 py-3 text-right"><?= showMoney($bal) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Profit Ledger -->
<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900"><i class="bi bi-graph-up-arrow text-emerald-500 me-2"></i> Profit</h5>
    </div>
    <div class="px-6 py-3 border-b border-gray-100 bg-gray-50/50">
        <div class="flex flex-wrap items-center gap-3">
            <input type="text" id="pf_from" class="datepicker px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-36" placeholder="From date">
            <input type="text" id="pf_to" class="datepicker px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-36" placeholder="To date">
            <button onclick="loadProfitLedger()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition">Filter</button>
            <button onclick="resetProfitLedger()" class="bg-white border border-gray-200 text-gray-600 px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">Reset</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="text-left px-4 py-3 font-semibold">SL</th>
                    <th class="text-left px-4 py-3 font-semibold">Date</th>
                    <th class="text-left px-4 py-3 font-semibold">Description</th>
                    <th class="text-right px-4 py-3 font-semibold">Debit</th>
                    <th class="text-right px-4 py-3 font-semibold">Credit</th>
                    <th class="text-right px-4 py-3 font-semibold">Balance</th>
                </tr>
            </thead>
            <tbody id="profitBody" class="divide-y divide-gray-100"></tbody>
            <tfoot>
                <tr class="bg-gray-50 font-semibold text-sm">
                    <td colspan="3" class="px-4 py-3 text-right text-gray-600">Total</td>
                    <td id="profitDebit" class="px-4 py-3 text-right text-rose-600">$0.00</td>
                    <td id="profitCredit" class="px-4 py-3 text-right text-emerald-600">$0.00</td>
                    <td id="profitBalance" class="px-4 py-3 text-right">$0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
function loadProfitLedger() {
    var from = $('#pf_from').val();
    var to = $('#pf_to').val();
    $.get('<?= domain ?>includes/ajax_profit_ledger.php', { investor_id: <?= $inv_id ?>, from_date: from, to_date: to }, function(data) {
        $('#profitBody').html(data.rows);
        $('#profitDebit').text(data.debit);
        $('#profitCredit').text(data.credit);
        $('#profitBalance').text(data.balance);
    });
}
function resetProfitLedger() {
    $('#pf_from, #pf_to').val('');
    loadProfitLedger();
}
$(document).ready(function() { loadProfitLedger(); });
</script>

<?php require_once 'includes/footer.php'; ?>
