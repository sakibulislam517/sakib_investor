<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';
checkAdminLogin();

$title = 'Add Investor';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $profit_percent = $_POST['profit_percent'];
    $status = $_POST['status'];

    $sql = "INSERT INTO investors (name, phone, email, username, password, address, profit_percent, status) VALUES 
            ('$name', '$phone', '$email', '$username', '$password', '$address', '$profit_percent', '$status')";
    if ($db->insert($sql)) {
        echo "<script>Swal.fire('Success!','Investor added successfully.','success').then(()=>location='investors.php')</script>";
    } else {
        echo "<script>Swal.fire('Error!','Failed to add investor.','error')</script>";
    }
}
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= domain ?>admin/investors.php" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Add Investor</h1>
</div>

<div class="content-card max-w-3xl">
    <div class="p-6">
        <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone <span class="text-rose-500">*</span></label>
                <input type="text" name="phone" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-rose-500">*</span></label>
                <input type="text" name="username" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Admin Profit Share (%) <span class="text-rose-500">*</span></label>
                <input type="number" name="profit_percent" value="0" min="0" max="100" step="0.01" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                <p class="text-xs text-gray-400 mt-1">Investor share = 100% - Admin Share</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="md:col-span-2 flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-medium transition shadow-sm">Save Investor</button>
                <a href="<?= domain ?>admin/investors.php" class="bg-white border border-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
