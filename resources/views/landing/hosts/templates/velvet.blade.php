<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - бархатная сцена</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Spectral:wght@500;700&family=Onest:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root { --wine: #3b0718; --ruby: #b91c1c; --gold: #f6c453; --peach: #ffb86b; --cream: #fff3dc; --ink: #1f1115; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--cream); font-family: Onest, sans-serif; background: radial-gradient(circle at 18% 18%, rgba(246,196,83,.28), transparent 22%), radial-gradient(circle at 82% 22%, rgba(255,184,107,.2), transparent 24%), linear-gradient(135deg, #21030d, var(--wine) 52%, #111827); }
        .stage { min-height: 100vh; padding: 34px 24px 72px; position: relative; overflow: hidden; }
        .stage:before, .stage:after { content: ""; position: fixed; top: -10vh; bottom: -10vh; width: 20vw; background: linear-gradient(90deg, rgba(185,28,28,.55), rgba(185,28,28,0)); filter: blur(2px); }
        .stage:before { left: 0; }
        .stage:after { right: 0; transform: scaleX(-1); }
        .wrap { max-width: 1160px; margin: 0 auto; position: relative; z-index: 1; }
        nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 48px; }
        .brand { font-family: "Bebas Neue", sans-serif; letter-spacing: .12em; font-size: 28px; color: var(--gold); }
        .pill { border: 1px solid rgba(246,196,83,.48); border-radius: 999px; padding: 11px 18px; background: rgba(255,255,255,.08); }
        .hero { display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: stretch; }
        .copy { border: 1px solid rgba(246,196,83,.38); border-radius: 40px; padding: clamp(32px, 6vw, 72px); background: linear-gradient(145deg, rgba(255,255,255,.1), rgba(255,255,255,.03)); box-shadow: 0 34px 100px rgba(0,0,0,.28); }
        .eyebrow { color: var(--peach); text-transform: uppercase; letter-spacing: .2em; font-weight: 900; }
        h1 { font-family: Spectral, serif; font-size: clamp(48px, 8vw, 112px); line-height: .88; margin: 14px 0 22px; letter-spacing: -.06em; }
        .lead { font-size: 20px; line-height: 1.75; color: rgba(255,243,220,.82); max-width: 680px; }
        .cta { display: inline-flex; margin-top: 18px; padding: 16px 24px; border-radius: 999px; background: linear-gradient(135deg, var(--gold), var(--peach)); color: var(--ink); text-decoration: none; font-weight: 900; box-shadow: 0 14px 36px rgba(246,196,83,.28); }
        .marquee { display: grid; gap: 16px; }
        .card { border-radius: 28px; padding: 24px; color: var(--ink); background: var(--cream); box-shadow: 12px 12px 0 rgba(246,196,83,.22); }
        .card:nth-child(even) { background: #ffe2a8; }
        .card strong { display: block; font-family: "Bebas Neue", sans-serif; font-size: 48px; color: var(--ruby); line-height: 1; }
        .events { margin-top: 26px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .event { border: 1px solid rgba(246,196,83,.32); border-radius: 26px; padding: 22px; background: rgba(255,255,255,.08); }
        @media (max-width: 900px) { nav, .hero, .events { grid-template-columns: 1fr; display: grid; } .hero { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="stage">
        <div class="wrap">
            <nav>
                <div class="brand">{{ $tenant->name }}</div>
                <div class="pill">Премиальная подача и сильная сцена</div>
            </nav>

            <section class="hero">
                <div class="copy">
                    <div class="eyebrow">Host performance</div>
                    <h1>Вечер с эффектом театральной премьеры</h1>
                    <p class="lead">Глубокий, контрастный лендинг для ведущего, который работает со статусными свадьбами, премиями и камерными частными событиями.</p>
                    <a class="cta" href="mailto:{{ $tenant->email }}">Обсудить мероприятие</a>
                </div>
                <aside class="marquee">
                    <div class="card"><strong>{{ $stats['events'] }}</strong>событий</div>
                    <div class="card"><strong>{{ $stats['guests'] }}</strong>гостей</div>
                    <div class="card"><strong>{{ $stats['vendors'] }}</strong>партнёров</div>
                    <div class="card"><strong>{{ number_format($stats['budget'], 0, '.', ' ') }}</strong>₽ бюджет</div>
                </aside>
            </section>

            <section class="events">
                @forelse($featuredEvents as $event)
                    <article class="event"><h3>{{ $event['title'] }}</h3><p>{{ $event['event_date'] }} · {{ $event['venue_name'] ?? 'Площадка уточняется' }}</p></article>
                @empty
                    <article class="event"><h3>Премии</h3><p>Сценический темп, акценты и уверенная модерация.</p></article>
                    <article class="event"><h3>Свадьбы</h3><p>Эмоциональная драматургия без лишнего шума.</p></article>
                    <article class="event"><h3>Частные вечера</h3><p>Тонкая работа с гостями и атмосферой.</p></article>
                @endforelse
            </section>
        </div>
    </main>
</body>
</html>
