<?php
$inv_data = $db->getAll('investors', " AND id = {$_SESSION['investor_id']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> — <?= getCompanyName() ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .sidebar-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.25rem; color: #94a3b8; transition: all 0.2s; border-radius: 0.5rem; margin: 0.125rem 0.5rem; font-size: 0.9rem; font-weight: 500; text-decoration: none; }
        .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-link.active { background: rgba(99,102,241,0.15); color: #818cf8; }
        .stat-card { border-radius: 1rem; padding: 1.5rem; color: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .stat-card h3 { font-size: 1.75rem; font-weight: 700; margin: 0; line-height: 1.2; }
        .stat-card p { margin: 0; opacity: 0.85; font-size: 0.875rem; }
        .content-card { background: #fff; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; }
        .dt-length, .dt-info { font-size: 0.875rem; color: #64748b; }
        .dt-paging .dt-paging-button { padding: 0.375rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #fff; color: #475569; font-size: 0.875rem; cursor: pointer; }
        .dt-paging .dt-paging-button.current { background: #6366f1; color: #fff; border-color: #6366f1; }
        .dt-paging .dt-paging-button:hover:not(.current) { background: #f1f5f9; }
        .dt-search input { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.375rem 0.75rem; font-size: 0.875rem; outline: none; }
        .dt-search input:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.15); }
        table.dataTable { border-collapse: separate; border-spacing: 0; }
        table.dataTable thead th { background: #f8fafc; color: #475569; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.75rem 1rem; border-bottom: 2px solid #e2e8f0; }
        table.dataTable tbody td { padding: 0.75rem 1rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        table.dataTable tbody tr:hover { background: #f8fafc; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
<div class="flex h-screen overflow-hidden">
