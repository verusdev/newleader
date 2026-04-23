<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - шоу и мероприятия</title>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@600;800&family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --bg: #07111f; --cyan: #55f7ff; --lime: #ddff4f; --pink: #ff3f9d; --text: #f8fbff; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--text); font-family: "Space Grotesk", sans-serif; background: radial-gradient(circle at 15% 20%, rgba(85,247,255,.22), transparent 28%), radial-gradient(circle at 85% 10%, rgba(255,63,157,.22), transparent 30%), linear-gradient(135deg, #07111f, #111827); }
        .noise { min-height: 100vh; padding: 34px 24px 70px; background-image: repeating-linear-gradient(0deg, rgba(255,255,255,.03) 0 1px, transparent 1px 3px); }
        .wrap { max-width: 1180px; margin: 0 auto; }
        nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 62px; }
        .logo { font-family: Unbounded, sans-serif; font-weight: 800; color: var(--lime); }
        .pill { border: 1px solid rgba(255,255,255,.22); border-radius: 999px; padding: 10px 16px; backdrop-filter: blur(10px); }
        .hero { border: 1px solid rgba(255,255,255,.18); border-radius: 40px; padding: clamp(28px, 6vw, 70px); background: rgba(255,255,255,.06); box-shadow: 0 0 80px rgba(85,247,255,.12); overflow: hidden; position: relative; }
        .hero:after { content: ""; position: absolute; width: 360px; height: 360px; right: -80px; top: -90px; border-radius: 50%; background: linear-gradient(135deg, var(--pink), var(--cyan)); filter: blur(20px); opacity: .45; }
        h1 { position: relative; z-index: 1; font-family: Unbounded, sans-serif; font-size: clamp(44px, 8vw, 112px); line-height: .92; margin: 0; letter-spacing: -.06em; max-width: 920px; }
        .lead { position: relative; z-index: 1; font-size: 20px; line-height: 1.7; max-width: 680px; color: #cbd5e1; }
        .cta { position: relative; z-index: 1; display: inline-flex; margin-top: 18px; padding: 16px 24px; border-radius: 18px; background: var(--lime); color: #0f172a; text-decoration: none; font-weight: 800; box-shadow: 8px 8px 0 var(--pink); }
        .grid { margin-top: 26px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .card { border-radius: 28px; padding: 24px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14); }
        .card strong { display: block; font-family: Unbounded, sans-serif; color: var(--cyan); font-size: 34px; }
        @media (max-width: 850px) { nav, .grid { grid-template-columns: 1fr; display: grid; gap: 14px; } }
    </style>
</head>
<body>
    <main class="noise">
        <div class="wrap">
            <nav>
                <div class="logo">{{ $tenant->name }}</div>
                <div class="pill">Шоу, драйв, точный тайминг</div>
            </nav>
            <section class="hero">
                <h1>Ведущий, которого запомнят</h1>
                <p class="lead">Смелый лендинг для активной рекламы: быстро показывает стиль, масштаб и готовность вести свадьбы, вечеринки и корпоративы.</p>
                <a class="cta" href="mailto:{{ $tenant->email }}">Забронировать шоу</a>
            </section>
            <section class="grid">
                <div class="card"><strong>{{ $stats['events'] }}</strong>событий</div>
                <div class="card"><strong>{{ $stats['guests'] }}</strong>гостей</div>
                <div class="card"><strong>{{ $stats['vendors'] }}</strong>партнёров</div>
                <div class="card"><strong>{{ number_format($stats['budget'], 0, '.', ' ') }}</strong>₽ в бюджете</div>
            </section>
        </div>
    </main>
</body>
</html>
