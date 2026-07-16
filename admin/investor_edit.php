<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$id = intval($_GET['id'] ?? 0);
$investor = $db->getAll('investors', " AND id = $id");
if (!$investor) {
    header('Location: ' . domain . 'admin/investors.php');
    exit;
}

$title = 'Edit Investor';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $profit_percent = $_POST['profit_percent'];
    $status = $_POST['status'];

    $pass_sql = '';
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $pass_sql = ", password = '$password'";
    }

    $sql = "UPDATE investors SET name = '$name', phone = '$phone', email = '$email', address = '$address', 
            profit_percent = '$profit_percent', status = '$status' $pass_sql WHERE id = $id";
    if ($db->edit($sql)) {
        echo "<script>Swal.fire('Success!','Investor updated successfully.','success').then(()=>location='investors.php')</script>";
    } else {
        echo "<script>Swal.fire('Info','No changes made.','info')</script>";
    }
}
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= domain ?>admin/investors.php" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Edit Investor — <?= htmlspecialchars($investor['name']) ?></h1>
</div>

<div class="content-card max-w-3xl">
    <div class="p-6">
        <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="<?= htmlspecialchars($investor['name']) ?>" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone <span class="text-rose-500">*</span></label>
                <input type="text" name="phone" value="<?= htmlspecialchars($investor['phone']) ?>" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($investor['email']) ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
                <input type="text" value="<?= htmlspecialchars($investor['username']) ?>" readonly class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-gray-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password (leave empty to keep)</label>
                <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Admin Profit Share (%) <span class="text-rose-500">*</span></label>
                <input type="number" name="profit_percent" value="<?= $investor['profit_percent'] ?>" min="0" max="100" step="0.01" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                <p class="text-xs text-gray-400 mt-1">Investor share = <?= 100 - $investor['profit_percent'] ?>%</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition"><?= htmlspecialchars($investor['address']) ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    <option value="1" <?= $investor['status'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $investor['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="md:col-span-2 flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">Update Investor</button>
                <a href="<?= domain ?>admin/investors.php" class="bg-white border border-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
