<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Settings';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$setting = $db->getAll('settings', ' AND id = 1');
if (!$setting) {
    $db->insert("INSERT INTO settings (company_name, currency) VALUES ('Investor Profit Management', 'USD')");
    $setting = $db->getAll('settings', ' AND id = 1');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'];
    $currency = $_POST['currency'];
    $timezone = $_POST['timezone'];

    $sql = "UPDATE settings SET company_name = '$company_name', currency = '$currency', timezone = '$timezone' WHERE id = 1";
    if ($db->edit($sql)) {
        echo "<script>Swal.fire('Success!','Settings updated.','success')</script>";
        $setting = $db->getAll('settings', ' AND id = 1');
    }
}
?>

<h1 class="text-2xl font-bold text-gray-900 mb-6">Settings</h1>

<div class="content-card max-w-2xl">
    <div class="p-6">
        <form method="post" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name</label>
                <input type="text" name="company_name" value="<?= htmlspecialchars($setting['company_name']) ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Currency</label>
                <select name="currency" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    <option value="USD" <?= $setting['currency'] == 'USD' ? 'selected' : '' ?>>USD ($)</option>
                    <option value="EUR" <?= $setting['currency'] == 'EUR' ? 'selected' : '' ?>>EUR (€)</option>
                    <option value="GBP" <?= $setting['currency'] == 'GBP' ? 'selected' : '' ?>>GBP (£)</option>
                    <option value="BDT" <?= $setting['currency'] == 'BDT' ? 'selected' : '' ?>>BDT (৳)</option>
                    <option value="INR" <?= $setting['currency'] == 'INR' ? 'selected' : '' ?>>INR (₹)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Timezone</label>
                <select name="timezone" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    <?php
                    $zones = ['Asia/Dhaka', 'Asia/Kolkata', 'Asia/Singapore', 'UTC', 'America/New_York', 'America/Chicago', 'America/Los_Angeles', 'Europe/London'];
                    foreach ($zones as $z):
                    ?>
                    <option value="<?= $z ?>" <?= ($setting['timezone'] ?? 'Asia/Dhaka') == $z ? 'selected' : '' ?>><?= $z ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="pt-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
