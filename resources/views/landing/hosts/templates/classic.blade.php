<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - ведущий мероприятий</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #1f2933; --gold: #c59b55; --cream: #fff8ed; --soft: #f2e6d2; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Manrope, sans-serif; color: var(--ink); background: linear-gradient(135deg, var(--cream), #ffffff 55%, var(--soft)); }
        .wrap { max-width: 1160px; margin: 0 auto; padding: 32px 24px 64px; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 70px; }
        .brand { font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
        .badge { border: 1px solid rgba(31, 41, 51, .16); border-radius: 999px; padding: 10px 18px; background: rgba(255,255,255,.7); }
        .hero { display: grid; grid-template-columns: 1.1fr .9fr; gap: 48px; align-items: center; }
        h1 { font-family: "Playfair Display", serif; font-size: clamp(48px, 8vw, 104px); line-height: .9; margin: 0 0 24px; letter-spacing: -.05em; }
        .lead { font-size: 20px; line-height: 1.7; max-width: 620px; color: #52606d; }
        .panel { border-radius: 36px; padding: 34px; background: #fff; box-shadow: 0 30px 90px rgba(80, 64, 42, .18); position: relative; overflow: hidden; }
        .panel:before { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 80% 10%, rgba(197,155,85,.28), transparent 34%); }
        .metric { position: relative; display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
        .metric div { border-radius: 24px; padding: 22px; background: var(--cream); }
        .metric strong { display: block; font-size: 34px; color: var(--gold); }
        .cta { display: inline-flex; margin-top: 28px; padding: 16px 26px; border-radius: 999px; background: var(--ink); color: white; text-decoration: none; font-weight: 800; }
        .events { margin-top: 70px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .event { padding: 24px; border-radius: 26px; background: rgba(255,255,255,.75); border: 1px solid rgba(31,41,51,.08); }
        @media (max-width: 800px) { .hero, .events { grid-template-columns: 1fr; } .nav { margin-bottom: 36px; } }
    </style>
</head>
<body>
    <main class="wrap">
        <nav class="nav">
            <div class="brand">{{ $tenant->name }}</div>
            <div class="badge">Организация событий под ключ</div>
        </nav>

        <section class="hero">
            <div>
                <h1>Ваш праздник звучит уверенно</h1>
                <p class="lead">Персональный лендинг ведущего: презентация услуг, доверие через портфолио и быстрый контакт для заявки на мероприятие.</p>
                <a class="cta" href="mailto:{{ $tenant->email }}">Обсудить дату</a>
            </div>
            <aside class="panel">
                <div class="metric">
                    <div><strong>{{ $stats['events'] }}</strong>мероприятий в CRM</div>
                    <div><strong>{{ $stats['guests'] }}</strong>гостей в списках</div>
                    <div><strong>{{ $stats['vendors'] }}</strong>партнёров</div>
                    <div><strong>{{ number_format($stats['budget'], 0, '.', ' ') }}</strong>руб. учтено</div>
                </div>
            </aside>
        </section>

        <section class="events">
            @forelse($featuredEvents as $event)
                <article class="event">
                    <h3>{{ $event['title'] }}</h3>
                    <p>{{ $event['event_date'] }} · {{ $event['venue_name'] ?? 'Площадка уточняется' }}</p>
                </article>
            @empty
                <article class="event"><h3>Свадьбы</h3><p>Элегантный сценарий и координация вечера.</p></article>
                <article class="event"><h3>Юбилеи</h3><p>Тёплая программа для семьи и друзей.</p></article>
                <article class="event"><h3>Корпоративы</h3><p>Динамика, тайминг и деликатный юмор.</p></article>
            @endforelse
        </section>
    </main>
</body>
</html>
