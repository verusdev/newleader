<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SaaS Platform')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Playfair+Display:wght@800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #172033;
            --muted: #64748b;
            --sun: #facc15;
            --coral: #fb7185;
            --blue: #38bdf8;
            --green: #34d399;
            --violet: #7c3aed;
        }

        body {
            font-family: Manrope, sans-serif;
            color: var(--ink);
            background: #fff7ed;
        }

        .navbar-white {
            background: rgba(255, 255, 255, .88) !important;
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(23, 32, 51, .08);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .system-hero {
            position: relative;
            overflow: hidden;
            padding: 96px 0 76px;
            color: white;
            background:
                radial-gradient(circle at 10% 12%, rgba(250, 204, 21, .45), transparent 24%),
                radial-gradient(circle at 85% 14%, rgba(56, 189, 248, .38), transparent 28%),
                linear-gradient(135deg, #15111f 0%, #7c2d12 44%, #be123c 100%);
        }

        .system-hero:after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(115deg, rgba(255,255,255,.08) 0 1px, transparent 1px 18px);
            pointer-events: none;
        }

        .hero-glow {
            position: absolute;
            border-radius: 999px;
            filter: blur(22px);
            opacity: .6;
        }

        .hero-glow-one {
            width: 260px;
            height: 260px;
            left: -80px;
            bottom: 70px;
            background: var(--green);
        }

        .hero-glow-two {
            width: 360px;
            height: 360px;
            right: -110px;
            top: 70px;
            background: var(--violet);
        }

        .hero-kicker,
        .section-heading span,
        .section-label {
            display: inline-flex;
            margin-bottom: 18px;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.16);
            color: #fff7d6;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: "Playfair Display", serif;
            font-size: clamp(50px, 8vw, 104px);
            line-height: .9;
            letter-spacing: -.06em;
            margin: 0 0 24px;
        }

        .hero-lead {
            max-width: 620px;
            color: rgba(255,255,255,.82);
            font-size: 20px;
            line-height: 1.75;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin: 30px 0 24px;
        }

        .btn-sun {
            background: var(--sun);
            color: #1f2937;
            border: 0;
            font-weight: 800;
            box-shadow: 9px 9px 0 rgba(56,189,248,.35);
        }

        .btn-glass {
            color: white;
            border: 1px solid rgba(255,255,255,.36);
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(12px);
            font-weight: 800;
        }

        .hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            color: rgba(255,255,255,.82);
            font-weight: 700;
        }

        .hero-points span {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.1);
        }

        .hero-points i {
            color: var(--green);
            margin-right: 6px;
        }

        .hero-collage {
            position: relative;
            min-height: 560px;
        }

        .hero-photo {
            position: absolute;
            object-fit: cover;
            border: 6px solid rgba(255,255,255,.86);
            box-shadow: 0 28px 90px rgba(0,0,0,.3);
        }

        .hero-photo-main {
            inset: 0 78px 80px 0;
            width: calc(100% - 78px);
            height: 480px;
            border-radius: 46px;
        }

        .hero-photo-small {
            right: 0;
            bottom: 0;
            width: 280px;
            height: 220px;
            border-radius: 34px;
        }

        .dashboard-card {
            position: absolute;
            left: 28px;
            bottom: 34px;
            width: 280px;
            padding: 22px;
            border-radius: 28px;
            background: rgba(255,255,255,.92);
            color: var(--ink);
            box-shadow: 0 24px 70px rgba(0,0,0,.22);
        }

        .dashboard-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            font-weight: 800;
        }

        .dashboard-line {
            height: 10px;
            border-radius: 999px;
            margin-bottom: 10px;
        }

        .line-pink { width: 96%; background: var(--coral); }
        .line-blue { width: 78%; background: var(--blue); }
        .line-green { width: 58%; background: var(--green); }
        .dashboard-note { color: var(--muted); font-size: 13px; font-weight: 700; }

        .showcase-strip {
            margin-top: -38px;
            position: relative;
            z-index: 2;
        }

        .stat-tile {
            min-height: 150px;
            border-radius: 30px;
            padding: 24px;
            background: white;
            box-shadow: 0 24px 70px rgba(124,45,18,.12);
        }

        .stat-tile strong {
            display: block;
            font-family: "Playfair Display", serif;
            color: #be123c;
            font-size: 46px;
            line-height: 1;
        }

        .stat-tile span {
            color: var(--muted);
            font-weight: 800;
        }

        .feature-gallery,
        .workflow-section,
        .plans-section {
            padding: 82px 0;
        }

        .section-heading {
            max-width: 760px;
            margin: 0 auto 42px;
            text-align: center;
        }

        .section-heading span,
        .section-label {
            background: #fff1c2;
            color: #9a3412;
        }

        .section-heading h2,
        .workflow-panel h2 {
            font-family: "Playfair Display", serif;
            font-size: clamp(36px, 5vw, 62px);
            line-height: .95;
            letter-spacing: -.05em;
            margin: 0;
        }

        .feature-card {
            overflow: hidden;
            min-height: 100%;
            border: 0;
            border-radius: 34px;
            background: white;
            box-shadow: 0 28px 80px rgba(23,32,51,.12);
        }

        .feature-card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
        }

        .feature-body {
            padding: 28px;
        }

        .feature-body i {
            width: 54px;
            height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            margin-bottom: 16px;
            color: white;
            font-size: 22px;
        }

        .feature-hot .feature-body i { background: linear-gradient(135deg, #fb7185, #f97316); }
        .feature-cool .feature-body i { background: linear-gradient(135deg, #38bdf8, #2563eb); }
        .feature-green .feature-body i { background: linear-gradient(135deg, #34d399, #059669); }

        .feature-body h3 {
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .feature-body p {
            color: var(--muted);
            line-height: 1.7;
        }

        .workflow-section {
            background:
                radial-gradient(circle at 12% 18%, rgba(251,113,133,.22), transparent 28%),
                radial-gradient(circle at 88% 20%, rgba(52,211,153,.18), transparent 28%),
                #fff;
        }

        .workflow-panel {
            border-radius: 42px;
            padding: 28px;
            background: linear-gradient(135deg, #172033, #7c2d12);
            color: white;
            box-shadow: 0 34px 100px rgba(23,32,51,.24);
        }

        .workflow-image {
            width: 100%;
            min-height: 420px;
            object-fit: cover;
            border-radius: 32px;
        }

        .workflow-list {
            display: grid;
            gap: 14px;
            margin-top: 28px;
        }

        .workflow-list div {
            display: flex;
            gap: 16px;
            padding: 18px;
            border-radius: 22px;
            background: rgba(255,255,255,.1);
        }

        .workflow-list strong {
            color: var(--sun);
            font-size: 22px;
        }

        .plans-section {
            background: linear-gradient(180deg, #fff7ed, #fef3c7);
        }

        .pricing-card {
            overflow: hidden;
            border: 0;
            border-radius: 34px;
            box-shadow: 0 26px 80px rgba(23,32,51,.12);
            transition: transform .3s, box-shadow .3s;
        }

        .pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 34px 100px rgba(190,18,60,.18);
        }

        .pricing-card .card-header {
            position: relative;
            overflow: hidden;
            padding: 28px 22px;
            color: white;
            border: 0;
            background: linear-gradient(135deg, #be123c, #7c3aed);
        }

        .plan-orbit {
            position: absolute;
            width: 120px;
            height: 120px;
            right: -32px;
            top: -42px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(250,204,21,.95), rgba(250,204,21,0) 66%);
        }

        .pricing-card .card-footer {
            border: 0;
            background: white;
            padding: 0 24px 28px;
        }

        .btn-gradient {
            border: 0;
            color: white;
            font-weight: 900;
            background: linear-gradient(135deg, #f97316, #be123c 50%, #7c3aed);
        }

        .main-footer {
            border-top: 0;
        }

        @media (max-width: 991px) {
            .system-hero { padding-top: 72px; }
            .hero-collage { min-height: 460px; }
            .hero-photo-main { height: 390px; }
        }

        @media (max-width: 767px) {
            .hero-title { font-size: 48px; }
            .hero-collage { min-height: 390px; }
            .hero-photo-main {
                inset: 0;
                width: 100%;
                height: 320px;
            }
            .hero-photo-small { display: none; }
            .dashboard-card {
                left: 16px;
                right: 16px;
                width: auto;
            }
            .workflow-panel { padding: 18px; }
            .workflow-image { min-height: 260px; }
        }
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
                    <a href="{{ global_asset('admin/tenants') }}" class="nav-link">Админ</a>
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
