{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HR Система')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f0f4f8;
            color: #1a202c;
            line-height: 1.3;
            min-height: 100vh;
            font-size: 12px;
        }

        /* ===== САЙДБАР ===== */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 160px;
            overflow-y: auto;
            padding: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed {
            width: 44px;
        }

        .sidebar.collapsed .sidebar-brand h1 {
            font-size: 11px;
        }

        .sidebar.collapsed .sidebar-brand span {
            display: none;
        }

        .sidebar.collapsed .sidebar-brand {
            padding: 8px 4px;
            text-align: center;
        }

        .sidebar.collapsed .nav-link span:not(.badge) {
            display: none;
        }

        .sidebar.collapsed .nav-link .badge {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 6px 3px;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 14px;
        }

        .sidebar.collapsed .nav-section {
            text-align: center;
            font-size: 6px;
            padding: 6px 2px 3px 2px;
            letter-spacing: 0.3px;
        }

        .sidebar.collapsed .sidebar-toggle-btn {
            transform: rotate(180deg);
        }

        .sidebar-brand {
            padding: 10px 10px 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand a {
            text-decoration: none;
            display: block;
            flex: 1;
        }

        .sidebar-brand h1 {
            font-size: 14px;
            font-weight: 700;
            color: #1a202c;
            letter-spacing: -0.5px;
            margin: 0;
            transition: all 0.3s ease;
        }

        .sidebar-brand h1 span {
            color: #3182ce;
        }

        .sidebar-brand span {
            font-size: 9px;
            color: #718096;
            font-weight: 400;
            display: block;
            margin-top: 1px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle-btn {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            padding: 2px 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            margin-left: 3px;
        }

        .sidebar-toggle-btn:hover {
            background: #edf2f7;
        }

        .sidebar-toggle-btn i {
            font-size: 9px;
            color: #4a5568;
            transition: all 0.3s ease;
        }

        .sidebar-nav {
            padding: 0 4px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-nav {
            padding: 0 2px;
        }

        .sidebar-nav .nav-section {
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #a0aec0;
            padding: 8px 6px 3px 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar .nav-link {
            color: #4a5568;
            padding: 5px 6px;
            font-size: 11px;
            font-weight: 500;
            border-radius: 3px;
            transition: all 0.15s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            margin-bottom: 1px;
        }

        .sidebar .nav-link:hover {
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .sidebar .nav-link.active {
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .sidebar .nav-link i {
            margin-right: 6px;
            width: 14px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link.active i {
            color: #3182ce;
        }

        .sidebar .nav-link .badge {
            margin-left: auto;
            font-size: 8px;
            padding: 1px 4px;
            background: #ebf8ff;
            color: #3182ce;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link.active .badge {
            background: #3182ce;
            color: #ffffff;
        }

        /* ===== ОСНОВНОЙ КОНТЕНТ ===== */
        .main-wrapper {
            margin-left: 160px;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-wrapper.expanded {
            margin-left: 44px;
        }

        .main-content {
            padding: 8px 8px 8px 12px;
            background: #f0f4f8;
            min-height: 100vh;
            max-width: 100%;
        }

        /* ===== МОБИЛЬНАЯ НАВИГАЦИЯ ===== */
        .mobile-nav {
            display: none;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 4px 10px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .mobile-nav .navbar-brand {
            font-weight: 700;
            font-size: 13px;
            color: #1a202c;
            text-decoration: none;
        }

        .mobile-nav .navbar-brand span {
            color: #3182ce;
        }

        .mobile-nav .navbar-toggler {
            border: 1px solid #e2e8f0;
            padding: 2px 5px;
            border-radius: 3px;
            background: transparent;
            cursor: pointer;
        }

        .mobile-nav .navbar-toggler:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15);
        }

        .mobile-nav .dropdown-menu {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 4px;
            margin-top: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            background: #ffffff;
            position: absolute;
            right: 0;
            min-width: 140px;
        }

        .mobile-nav .dropdown-item {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
            color: #4a5568;
            text-decoration: none;
            display: block;
        }

        .mobile-nav .dropdown-item:hover {
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .mobile-nav .dropdown-item.active {
            background: #ebf8ff;
            color: #2b6cb0;
        }

        .mobile-nav .dropdown-item i {
            margin-right: 5px;
            width: 12px;
            color: #a0aec0;
        }

        .mobile-nav .dropdown-item.active i {
            color: #3182ce;
        }

        /* ===== ОВЕРЛЕЙ ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* ===== ЗАГОЛОВОК СТРАНИЦЫ ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 4px;
        }

        .page-header h2 {
            font-size: 15px;
            font-weight: 600;
            color: #1a202c;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .page-header .header-actions {
            display: flex;
            gap: 3px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ===== КАРТОЧКИ ===== */
        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            margin: 0;
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 5px 8px;
            font-weight: 600;
            font-size: 10px;
            color: #1a202c;
            border-radius: 4px 4px 0 0;
        }

        .card-body {
            padding: 6px 8px;
        }

        .card-body.p-0 {
            padding: 0;
        }

        /* ===== СТАТИСТИКА ===== */
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 6px 8px;
        }

        .stat-card .stat-label {
            font-size: 8px;
            color: #718096;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stat-card .stat-number {
            font-size: 16px;
            font-weight: 600;
            color: #1a202c;
            line-height: 1.2;
            margin-top: 1px;
        }

        .stat-card .stat-number.blue {
            color: #3182ce;
        }

        /* ===== ТАБЛИЦЫ ===== */
        .table-responsive {
            margin: 0;
            padding: 0;
            border: none;
        }

        .table {
            font-size: 10px;
            margin-bottom: 0;
            width: 100%;
        }

        .table thead th {
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #718096;
            padding: 3px 4px;
            white-space: nowrap;
            text-align: left;
        }

        .table tbody td {
            padding: 3px 4px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f4f8;
            color: #2d3748;
            font-size: 10px;
            text-align: left;
        }

        .table tbody tr:hover {
            background: #f7fafc;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table a {
            color: #3182ce;
            text-decoration: none;
        }

        .table a:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }

        /* ===== БЭЙДЖИ ===== */
        .badge {
            font-weight: 500;
            font-size: 7px;
            padding: 1px 4px;
            border-radius: 5px;
        }

        .badge-secondary {
            background: #edf2f7;
            color: #4a5568;
        }

        /* ===== КНОПКИ ===== */
        .btn {
            font-weight: 500;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 3px;
            transition: all 0.15s ease;
        }

        .btn-primary {
            background: #3182ce;
            border-color: #3182ce;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #2b6cb0;
            border-color: #2b6cb0;
            color: #ffffff;
        }

        .btn-outline-secondary {
            color: #4a5568;
            border-color: #e2e8f0;
            background: transparent;
        }

        .btn-outline-secondary:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
        }

        .btn-danger {
            background: #e53e3e;
            border-color: #e53e3e;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #c53030;
            border-color: #c53030;
            color: #ffffff;
        }

        .btn-sm {
            padding: 1px 4px;
            font-size: 9px;
        }

        .btn-group .btn {
            border-radius: 3px;
        }

        .btn-group .btn:not(:last-child) {
            margin-right: 1px;
        }

        /* ===== ПРОГРЕСС ===== */
        .progress {
            height: 2px;
            border-radius: 2px;
            background: #edf2f7;
        }

        .progress-bar {
            background: #3182ce;
            border-radius: 2px;
        }

        /* ===== ФОРМЫ ===== */
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            padding: 3px 5px;
            font-size: 10px;
            color: #2d3748;
        }

        .form-control:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.12);
            outline: none;
        }

        .form-label {
            font-weight: 500;
            font-size: 10px;
            color: #4a5568;
            margin-bottom: 1px;
        }

        .input-group-text {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            color: #4a5568;
            padding: 3px 5px;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 992px) {
            .main-content {
                padding: 6px 6px 6px 8px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 220px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                transform: translateX(-100%);
                width: 220px;
            }

            .sidebar.collapsed.open {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-wrapper {
                margin-left: 0 !important;
            }

            .main-wrapper.expanded {
                margin-left: 0 !important;
            }

            .mobile-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .main-content {
                padding: 5px 5px 5px 6px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 3px;
            }

            .page-header h2 {
                font-size: 13px;
            }

            .stat-card .stat-number {
                font-size: 14px;
            }

            .table thead th {
                font-size: 6px;
                padding: 2px 3px;
            }

            .table tbody td {
                font-size: 9px;
                padding: 2px 3px;
            }

            .card-body {
                padding: 5px 6px;
            }

            .btn {
                font-size: 9px;
                padding: 2px 6px;
            }

            .btn-sm {
                font-size: 8px;
                padding: 1px 3px;
            }

            .stat-card {
                padding: 5px 6px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 4px 4px 4px 5px;
            }

            .stat-card {
                padding: 4px 5px;
            }

            .stat-card .stat-number {
                font-size: 12px;
            }

            .page-header h2 {
                font-size: 12px;
            }

            .table thead th {
                font-size: 5px;
                padding: 1px 2px;
            }

            .table tbody td {
                font-size: 8px;
                padding: 1px 2px;
            }

            .badge {
                font-size: 6px;
                padding: 0 3px;
            }

            .btn {
                font-size: 8px;
                padding: 1px 4px;
            }

            .btn-sm {
                font-size: 7px;
                padding: 1px 2px;
            }
        }

        .text-muted {
            color: #718096 !important;
        }
        .gap-1 { gap: 2px; }
        .fw-500 { font-weight: 500; }
        .fs-11 { font-size: 11px; }
        .text-left { text-align: left; }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Оверлей для мобильного меню -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Мобильная навигация -->
    <nav class="mobile-nav">
        <a class="navbar-brand" href="{{ route('employees.index') }}">
            HR<span>.</span>
        </a>
        <button class="navbar-toggler" type="button" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse" id="mobileMenu">
            <div class="dropdown-menu show position-absolute end-0" style="min-width: 140px;">
                <a class="dropdown-item {{ request()->routeIs('employees.*') ? 'active' : '' }}" 
                   href="{{ route('employees.index') }}">
                    <i class="fas fa-users"></i> Сотрудники
                </a>
                <a class="dropdown-item {{ request()->routeIs('vacations.*') ? 'active' : '' }}" 
                   href="{{ route('vacations.index') }}">
                    <i class="fas fa-calendar-alt"></i> Отпуска
                </a>
                <a class="dropdown-item {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
                   href="{{ route('reports.index') }}">
                    <i class="fas fa-chart-bar"></i> Аналитика
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-brand">
                    <a href="{{ route('employees.index') }}">
                        <h1>HR<span>.</span></h1>
                        <span>Управление</span>
                    </a>
                    <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Свернуть панель">
                        <i class="fas fa-chevron-left" id="toggleIcon"></i>
                    </button>
                </div>
                
                <nav class="sidebar-nav">
                    <div class="nav-section">Основное</div>
                    
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" 
                       href="{{ route('employees.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Сотрудники</span>
                        <span class="badge">{{ \App\Models\Employee::count() }}</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('vacations.*') ? 'active' : '' }}" 
                       href="{{ route('vacations.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Отпуска</span>
                    </a>
                    
                    <div class="nav-section">Аналитика</div>
                    
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
                       href="{{ route('reports.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Аналитика</span>
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="main-wrapper" id="mainWrapper">
                <div class="main-content">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h2>@yield('page-title', 'Панель управления')</h2>
                        <div class="header-actions">
                            @hasSection('header-actions')
                                @yield('header-actions')
                            @else
                                <span class="text-muted fs-11">
                                    {{ date('d.m.Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            const toggleIcon = document.getElementById('toggleIcon');
            
            sidebar.classList.toggle('collapsed');
            mainWrapper.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.className = 'fas fa-chevron-right';
            } else {
                toggleIcon.className = 'fas fa-chevron-left';
            }
            
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
                mainWrapper.classList.add('expanded');
                document.getElementById('toggleIcon').className = 'fas fa-chevron-right';
            }

            document.getElementById('sidebarOverlay').addEventListener('click', closeMobileMenu);

            const mobileLinks = document.querySelectorAll('#mobileMenu .dropdown-item');
            mobileLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    closeMobileMenu();
                    const collapse = document.getElementById('mobileMenu');
                    if (collapse.classList.contains('show')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(collapse);
                        if (bsCollapse) bsCollapse.hide();
                    }
                });
            });

            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
            sidebarLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) closeMobileMenu();
                });
            });

            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            
            if (window.innerWidth > 768) {
                closeMobileMenu();
                if (sidebar.classList.contains('collapsed')) {
                    mainWrapper.classList.add('expanded');
                }
            } else {
                mainWrapper.classList.remove('expanded');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
        });
    </script>
</body>
</html>