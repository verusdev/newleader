<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SaaS Platform')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Source Sans Pro', sans-serif; }
        .landing-hero { background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%); padding: 80px 0; color: white; }
        .pricing-card { transition: transform 0.3s; }
        .pricing-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="layout-top-nav">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="container">
            <a href="{{ route('landing.index') }}" class="navbar-brand">
                <i class="fas fa-store mr-2"></i> SaaS Platform
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('landing.index') }}" class="nav-link">Тарифы</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tenants.index') }}" class="nav-link">Админ</a>
                </li>
            </ul>
        </div>
    </nav>

    @yield('content')

    <footer class="main-footer bg-white mt-5">
        <div class="container">
            <div class="float-right d-none d-sm-block">Version 1.0.0</div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">SaaS Platform</a>.</strong> Все права защищены.
        </div>
    </footer>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
