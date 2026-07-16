    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 flex-shrink-0 hidden lg:flex flex-col">
        <div class="p-5 border-b border-slate-800">
            <h5 class="text-white font-bold text-base m-0"><?= getCompanyName() ?></h5>
            <span class="text-slate-400 text-xs">Welcome, <?= htmlspecialchars($inv_data['name'] ?? '') ?></span>
        </div>
        <nav class="flex-1 overflow-y-auto py-3">
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="<?= domain ?>investor/index.php">
                <i class="bi bi-speedometer2 text-lg"></i> Dashboard
            </a>
            <div class="px-5 pt-4 pb-1">
                <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Finance</span>
            </div>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'investment.php' ? 'active' : '' ?> ps-4" href="<?= domain ?>investor/investment.php">
                <i class="bi bi-pie-chart text-lg"></i> Current Investment
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'profit.php' ? 'active' : '' ?> ps-4" href="<?= domain ?>investor/profit.php">
                <i class="bi bi-graph-up text-lg"></i> Profit History
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'withdraw.php' ? 'active' : '' ?> ps-4" href="<?= domain ?>investor/withdraw.php">
                <i class="bi bi-arrow-up-right-circle text-lg"></i> Withdraw History
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'statement.php' ? 'active' : '' ?> ps-4" href="<?= domain ?>investor/statement.php">
                <i class="bi bi-file-text text-lg"></i> Statement
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>" href="<?= domain ?>investor/profile.php">
                <i class="bi bi-person text-lg"></i> Profile
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a class="sidebar-link" href="<?= domain ?>investor/logout.php">
                <i class="bi bi-box-arrow-left text-lg"></i> Logout
            </a>
        </div>
    </aside>
    <!-- Main wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between lg:hidden">
            <span class="font-semibold text-gray-800"><?= getCompanyName() ?></span>
            <span class="text-sm text-gray-500"><?= htmlspecialchars($inv_data['name'] ?? '') ?></span>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
