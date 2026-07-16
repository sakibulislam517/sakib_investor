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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .sidebar-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.25rem; color: #94a3b8; transition: all 0.2s; border-radius: 0.5rem; margin: 0.125rem 0.5rem; font-size: 0.9rem; font-weight: 500; text-decoration: none; }
        .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-link.active { background: rgba(79,70,229,0.15); color: #818cf8; }
        .stat-card { border-radius: 1rem; padding: 1.5rem; color: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .stat-card h3 { font-size: 1.75rem; font-weight: 700; margin: 0; line-height: 1.2; }
        .stat-card p { margin: 0; opacity: 0.85; font-size: 0.875rem; }
        .card-gradient-1 { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .card-gradient-2 { background: linear-gradient(135deg, #10b981, #34d399); }
        .card-gradient-3 { background: linear-gradient(135deg, #3b82f6, #06b6d4); }
        .card-gradient-4 { background: linear-gradient(135deg, #f59e0b, #f97316); }
        .card-gradient-5 { background: linear-gradient(135deg, #ef4444, #f43f5e); }
        .card-gradient-6 { background: linear-gradient(135deg, #1e293b, #334155); }
        .content-card { background: #fff; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; }
        .dt-length, .dt-info { font-size: 0.875rem; color: #64748b; }
        .dt-paging nav { display: flex; gap: 0.25rem; }
        .dt-paging .dt-paging-button { padding: 0.375rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #fff; color: #475569; font-size: 0.875rem; cursor: pointer; }
        .dt-paging .dt-paging-button.current { background: #6366f1; color: #fff; border-color: #6366f1; }
        .dt-paging .dt-paging-button:hover:not(.current) { background: #f1f5f9; }
        .dt-search input { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.375rem 0.75rem; font-size: 0.875rem; outline: none; }
        .dt-search input:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.15); }
        table.dataTable { border-collapse: separate; border-spacing: 0; }
        table.dataTable thead th { background: #f8fafc; color: #475569; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 0.75rem 1rem; border-bottom: 2px solid #e2e8f0; }
        table.dataTable tbody td { padding: 0.75rem 1rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        table.dataTable tbody tr:hover { background: #f8fafc; }
        .select2-container--default .select2-selection--single { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 0.375rem 0.75rem; height: auto; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { color: #1e293b; line-height: 1.5; }
        .flatpickr-input { background: #fff !important; }
        .investor-balance-link { color: #6366f1; text-decoration: none; font-weight: 500; }
        .investor-balance-link:hover { color: #4f46e5; text-decoration: underline; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
<div class="flex h-screen overflow-hidden">
