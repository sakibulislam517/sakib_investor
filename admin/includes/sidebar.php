    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 flex-shrink-0 hidden lg:flex flex-col">
        <div class="p-5 border-b border-slate-800">
            <h5 class="text-white font-bold text-base m-0"><?= getCompanyName() ?></h5>
            <span class="text-slate-400 text-xs">Admin Panel</span>
        </div>
        <nav class="flex-1 overflow-y-auto py-3">
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="<?= domain ?>admin/index.php">
                <i class="bi bi-speedometer2 text-lg"></i> Dashboard
            </a>
            <a class="sidebar-link <?= strpos(basename($_SERVER['PHP_SELF']), 'investor') !== false ? 'active' : '' ?>" href="<?= domain ?>admin/investors.php">
                <i class="bi bi-people text-lg"></i> Investors
            </a>
            <a class="sidebar-link <?= strpos(basename($_SERVER['PHP_SELF']), 'investment') !== false ? 'active' : '' ?>" href="<?= domain ?>admin/investments.php">
                <i class="bi bi-cash-stack text-lg"></i> Investments
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'profit.php' || basename($_SERVER['PHP_SELF']) == 'profit_add.php' ? 'active' : '' ?>" href="<?= domain ?>admin/profit.php">
                <i class="bi bi-graph-up-arrow text-lg"></i> Daily Profit
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'withdraw.php' || basename($_SERVER['PHP_SELF']) == 'withdraw_add.php' ? 'active' : '' ?>" href="<?= domain ?>admin/withdraw.php">
                <i class="bi bi-arrow-up-right-circle text-lg"></i> Withdrawals
            </a>
            <a class="sidebar-link <?= strpos($_SERVER['PHP_SELF'], 'reports') !== false ? 'active' : '' ?>" href="<?= domain ?>admin/reports/statement.php">
                <i class="bi bi-file-text text-lg"></i> Reports
            </a>
            <a class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>" href="<?= domain ?>admin/settings.php">
                <i class="bi bi-gear text-lg"></i> Settings
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <a class="sidebar-link" href="<?= domain ?>admin/logout.php">
                <i class="bi bi-box-arrow-left text-lg"></i> Logout
            </a>
        </div>
    </aside>
    <!-- Main wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between lg:hidden">
            <span class="font-semibold text-gray-800"><?= getCompanyName() ?></span>
            <span class="text-sm text-gray-500">Admin</span>
        </header>
        <!-- Content area -->
        <main class="flex-1 overflow-y-auto p-6">
