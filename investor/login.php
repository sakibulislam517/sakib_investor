<?php
require_once '../main.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

if (isInvestorLoggedIn()) {
    header('Location: ' . domain . 'investor/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if (investorLogin($username, $password)) {
        header('Location: ' . domain . 'investor/index.php');
        exit;
    } else {
        $error = 'Invalid username or password, or account is inactive!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investor Login — <?= getCompanyName() ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/20 rounded-2xl mb-4">
                <i class="bi bi-person-circle text-3xl text-emerald-400"></i>
            </div>
            <h1 class="text-2xl font-bold text-white"><?= getCompanyName() ?></h1>
            <p class="text-slate-400 text-sm mt-1">Investor Panel Login</p>
        </div>
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
            <?php if ($error): ?>
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-2">
                    <i class="bi bi-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            <form method="post" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
                    <div class="relative">
                        <i class="bi bi-person absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="username" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="bi bi-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition">
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl transition shadow-lg shadow-emerald-500/25">
                    Sign In
                </button>
            </form>
            <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                <a href="<?= domain ?>admin/login.php" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                    <i class="bi bi-shield-lock"></i> Admin Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
