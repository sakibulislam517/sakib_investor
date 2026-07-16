<?php
require_once '../../main.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkAdminLogin();

$title = 'Reports';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

$investor_id = intval($_GET['investor_id'] ?? 0);
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
$report_type = $_GET['report_type'] ?? 'statement';

$investors = $db->getFull('investors', 'id, name', ' ORDER BY name');
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Reports</h1>

<!-- Filters -->
<div class="content-card mb-6">
    <div class="p-6">
        <form method="get" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Type</label>
                <select name="report_type" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                    <option value="statement" <?= $report_type == 'statement' ? 'selected' : '' ?>>Investor Statement</option>
                    <option value="daily_profit" <?= $report_type == 'daily_profit' ? 'selected' : '' ?>>Daily Profit</option>
                    <option value="investment" <?= $report_type == 'investment' ? 'selected' : '' ?>>Investment</option>
                    <option value="profit" <?= $report_type == 'profit' ? 'selected' : '' ?>>Profit Report</option>
                    <option value="admin_income" <?= $report_type == 'admin_income' ? 'selected' : '' ?>>Admin Income</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">Investor</label>
                <select name="investor_id" class="select2 w-full">
                    <option value="">All Investors</option>
                    <?php foreach ($investors as $inv): ?>
                    <option value="<?= $inv['id'] ?>" <?= $investor_id == $inv['id'] ? 'selected' : '' ?>><?= htmlspecialchars($inv['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">From</label>
                <input type="text" name="from_date" class="datepicker w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" value="<?= $from_date ?>">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1 uppercase tracking-wide">To</label>
                <input type="text" name="to_date" class="datepicker w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none" value="<?= $to_date ?>">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">View Report</button>
            </div>
        </form>
    </div>
</div>

<div class="content-card">
    <div class="px-6 py-4 border-b border-gray-100">
        <h5 class="font-semibold text-gray-900">
            <?php
            $titles = ['statement'=>'Investor Statement','daily_profit'=>'Daily Profit Report','investment'=>'Investment Report','profit'=>'Profit Report','admin_income'=>'Admin Income Report'];
            echo $titles[$report_type] ?? 'Report';
            ?>
        </h5>
    </div>
    <div class="p-6">
        <?php
        $where_date = '';
        if ($from_date) $where_date .= " AND date >= '$from_date'";
        if ($to_date) $where_date .= " AND date <= '$to_date'";

        switch ($report_type):
            case 'statement':
        ?>
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Investor</th><th>Type</th><th>Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $w = "1 $where_date";
                if ($investor_id) $w .= " AND investor_id = $investor_id";
                $data = $db->getFull('investor_ledger', '*', " AND $w ORDER BY date DESC, id DESC");
                foreach ($data as $d):
                    $b = '';
                    switch($d['type']) {
                        case 'deposit': $b = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Deposit</span>'; break;
                        case 'investment_withdraw': $b = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Invest Withdraw</span>'; break;
                        case 'profit': $b = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-700">Profit</span>'; break;
                        case 'profit_withdraw': $b = '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Profit Withdraw</span>'; break;
                    }
                ?>
                <tr>
                    <td><?= $d['date'] ?></td><td><?= getInvestorName($d['investor_id']) ?></td>
                    <td><?= $b ?></td><td><?= showMoney($d['amount']) ?></td>
                    <td><?= htmlspecialchars($d['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php break; case 'daily_profit': ?>
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Investor</th><th>Gross</th><th>Admin %</th><th>Admin Amt</th><th>Investor Amt</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $w = "1 $where_date";
                if ($investor_id) $w .= " AND investor_id = $investor_id";
                $data = $db->getFull('daily_profit', '*', " AND $w ORDER BY date DESC, id DESC");
                foreach ($data as $d):
                ?>
                <tr>
                    <td><?= $d['date'] ?></td><td><?= getInvestorName($d['investor_id']) ?></td>
                    <td><?= showMoney($d['gross_profit']) ?></td><td><?= $d['admin_percent'] ?>%</td>
                    <td><?= showMoney($d['admin_amount']) ?></td><td><?= showMoney($d['investor_amount']) ?></td>
                    <td><?= htmlspecialchars($d['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php break; case 'investment': ?>
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Investor</th><th>Type</th><th>Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $w = "type IN ('deposit','investment_withdraw') $where_date";
                if ($investor_id) $w .= " AND investor_id = $investor_id";
                $data = $db->getFull('investor_ledger', '*', " AND $w ORDER BY date DESC, id DESC");
                foreach ($data as $d):
                    $lb = $d['type'] == 'deposit' ? '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Deposit</span>' : '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700">Withdraw</span>';
                ?>
                <tr>
                    <td><?= $d['date'] ?></td><td><?= getInvestorName($d['investor_id']) ?></td>
                    <td><?= $lb ?></td><td><?= showMoney($d['amount']) ?></td>
                    <td><?= htmlspecialchars($d['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php break; case 'profit': ?>
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Investor</th><th>Type</th><th>Amount</th><th>Remarks</th></tr>
            </thead>
            <tbody>
                <?php
                $w = "type IN ('profit','profit_withdraw') $where_date";
                if ($investor_id) $w .= " AND investor_id = $investor_id";
                $data = $db->getFull('investor_ledger', '*', " AND $w ORDER BY date DESC, id DESC");
                foreach ($data as $d):
                    $lb = $d['type'] == 'profit' ? '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-cyan-50 text-cyan-700">Credit</span>' : '<span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Withdraw</span>';
                ?>
                <tr>
                    <td><?= $d['date'] ?></td><td><?= getInvestorName($d['investor_id']) ?></td>
                    <td><?= $lb ?></td><td><?= showMoney($d['amount']) ?></td>
                    <td><?= htmlspecialchars($d['remarks']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php break; case 'admin_income': ?>
        <table class="datatable w-full">
            <thead>
                <tr><th>Date</th><th>Investor</th><th>Gross Profit</th><th>Admin %</th><th>Admin Amount</th></tr>
            </thead>
            <tbody>
                <?php
                $w = "1 $where_date";
                if ($investor_id) $w .= " AND investor_id = $investor_id";
                $data = $db->getFull('daily_profit', '*', " AND $w ORDER BY date DESC, id DESC");
                $total = 0;
                foreach ($data as $d): $total += $d['admin_amount'];
                ?>
                <tr>
                    <td><?= $d['date'] ?></td><td><?= getInvestorName($d['investor_id']) ?></td>
                    <td><?= showMoney($d['gross_profit']) ?></td><td><?= $d['admin_percent'] ?>%</td>
                    <td><?= showMoney($d['admin_amount']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="font-semibold bg-gray-50">
                    <th colspan="4" class="text-right">Total Admin Income:</th>
                    <th><?= showMoney($total) ?></th>
                </tr>
            </tfoot>
        </table>
        <?php break; endswitch; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
