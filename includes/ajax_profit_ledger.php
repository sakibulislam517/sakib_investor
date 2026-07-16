<?php
require_once __DIR__ . '/../main.php';
require_once __DIR__ . '/functions.php';

$investor_id = intval($_GET['investor_id'] ?? 0);
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';

$response = ['rows' => '', 'debit' => '$0.00', 'credit' => '$0.00', 'balance' => '$0.00'];

if (!$investor_id) {
    $response['rows'] = '<tr><td colspan="6" class="text-center text-gray-400 py-6">No investor specified.</td></tr>';
    echo json_encode($response);
    exit;
}

$where = "investor_id = $investor_id AND type IN ('profit','profit_withdraw')";
if ($from_date) $where .= " AND date >= '$from_date'";
if ($to_date) $where .= " AND date <= '$to_date'";

// Get balance before the from_date
$bal_before = 0;
if ($from_date) {
    $r = $db->getdata("SELECT COALESCE(SUM(CASE WHEN type='profit' THEN amount ELSE 0 END),0) - COALESCE(SUM(CASE WHEN type='profit_withdraw' THEN amount ELSE 0 END),0) as bal FROM investor_ledger WHERE investor_id = $investor_id AND date < '$from_date'");
    $bal_before = floatval($r[0]['bal'] ?? 0);
}

$txns = $db->getdata("SELECT * FROM investor_ledger WHERE $where ORDER BY date ASC, id ASC");
$bal = $bal_before;
$sl = 1;
$total_debit = 0;
$total_credit = 0;
$rows = '';

if (empty($txns)) {
    $rows = '<tr><td colspan="6" class="text-center text-gray-400 py-6">No transactions found.</td></tr>';
} else {
    foreach ($txns as $t):
        if ($t['type'] == 'profit_withdraw') {
            $bal -= $t['amount'];
            $credit = showMoney($t['amount']); $debit = '—';
            $desc = 'Withdraw' . ($t['remarks'] ? ' ('.htmlspecialchars($t['remarks']).')' : '');
            $total_credit += $t['amount'];
        } else {
            $bal += $t['amount'];
            $debit = showMoney($t['amount']); $credit = '—';
            $desc = 'Profit' . ($t['remarks'] ? ' ('.htmlspecialchars($t['remarks']).')' : '');
            $total_debit += $t['amount'];
        }
        $rows .= '<tr class="hover:bg-gray-50">';
        $rows .= '<td class="px-4 py-3 text-gray-500">'.$sl++.'</td>';
        $rows .= '<td class="px-4 py-3">'.$t['date'].'</td>';
        $rows .= '<td class="px-4 py-3">'.$desc.'</td>';
        $rows .= '<td class="px-4 py-3 text-right text-rose-600 font-medium">'.$debit.'</td>';
        $rows .= '<td class="px-4 py-3 text-right text-emerald-600 font-medium">'.$credit.'</td>';
        $rows .= '<td class="px-4 py-3 text-right font-semibold">'.showMoney($bal).'</td>';
        $rows .= '</tr>';
    endforeach;
}

$response = [
    'rows' => $rows,
    'debit' => showMoney($total_debit),
    'credit' => showMoney($total_credit),
    'balance' => showMoney($bal)
];
echo json_encode($response);
