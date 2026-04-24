<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - фестивальный ведущий</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Mono+One&family=Nunito:wght@500;700;900&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #151515; --sun: #ffd23f; --mint: #26d9a6; --pink: #ff4f8b; --blue: #3b82f6; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); font-family: Nunito, sans-serif; background: radial-gradient(circle at 8% 12%, var(--pink), transparent 18%), radial-gradient(circle at 86% 18%, var(--mint), transparent 20%), radial-gradient(circle at 72% 88%, var(--blue), transparent 22%), linear-gradient(135deg, #fff7ad, #ffe5ec 48%, #d7fff2); }
        .page { min-height: 100vh; padding: 30px 22px 70px; background-image: repeating-linear-gradient(-12deg, rgba(21,21,21,.06) 0 2px, transparent 2px 16px); }
        .wrap { max-width: 1180px; margin: 0 auto; }
        nav { display: flex; justify-content: space-between; gap: 16px; align-items: center; margin-bottom: 34px; }
        .brand, h1 { font-family: "Rubik Mono One", sans-serif; }
        .brand { font-size: 18px; background: var(--ink); color: white; padding: 12px 16px; transform: rotate(-2deg); }
        .tag { background: white; border: 3px solid var(--ink); border-radius: 999px; padding: 10px 18px; font-weight: 900; box-shadow: 6px 6px 0 var(--blue); }
        .hero { display: grid; grid-template-columns: 1.05fr .95fr; gap: 24px; align-items: stretch; }
        .poster { border: 4px solid var(--ink); border-radius: 34px; padding: clamp(28px, 5vw, 58px); background: rgba(255,255,255,.82); box-shadow: 14px 14px 0 var(--pink); position: relative; overflow: hidden; }
        .poster:after { content: ""; position: absolute; width: 210px; height: 210px; right: -52px; bottom: -52px; border-radius: 50%; background: conic-gradient(var(--sun), var(--pink), var(--blue), var(--mint), var(--sun)); opacity: .8; }
        h1 { position: relative; z-index: 1; font-size: clamp(42px, 7vw, 86px); line-height: .96; margin: 0; letter-spacing: -.05em; }
        .lead { position: relative; z-index: 1; font-size: 21px; line-height: 1.65; max-width: 680px; }
        .cta { position: relative; z-index: 1; display: inline-flex; margin-top: 14px; padding: 16px 24px; border: 3px solid var(--ink); border-radius: 18px; background: var(--sun); color: var(--ink); text-decoration: none; font-weight: 900; box-shadow: 7px 7px 0 var(--mint); }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .stat { border: 4px solid var(--ink); border-radius: 28px; padding: 24px; background: white; box-shadow: 10px 10px 0 rgba(21,21,21,.12); }
        .stat:nth-child(2) { background: #dcfce7; }
        .stat:nth-child(3) { background: #dbeafe; }
        .stat:nth-child(4) { background: #ffe4e6; }
        .stat strong { display: block; font-family: "Rubik Mono One", sans-serif; font-size: 34px; }
        .events { margin-top: 28px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .event { background: rgba(255,255,255,.78); border: 3px solid var(--ink); border-radius: 24px; padding: 20px; }
        @media (max-width: 850px) { nav, .hero, .events { grid-template-columns: 1fr; display: grid; } .stats { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="page">
        <div class="wrap">
            <nav>
                <div class="brand">{{ $tenant->name }}</div>
                <div class="tag">Свадьбы, вечеринки, корпоративы</div>
            </nav>

            <section class="hero">
                <div class="poster">
                    <h1>Праздник как большой летний фестиваль</h1>
                    <p class="lead">Шаблон для энергичного ведущего: яркие блоки, быстрый контакт, ощущение драйва и живой программы без скучных пауз.</p>
                    <a class="cta" href="mailto:{{ $tenant->email }}">Запросить дату</a>
                </div>
                <aside class="stats">
                    <div class="stat"><strong>{{ $stats['events'] }}</strong>событий в работе</div>
                    <div class="stat"><strong>{{ $stats['guests'] }}</strong>гостей в списках</div>
                    <div class="stat"><strong>{{ $stats['vendors'] }}</strong>партнёров</div>
                    <div class="stat"><strong>{{ number_format($stats['budget'], 0, '.', ' ') }}</strong>₽ учтено</div>
                </aside>
            </section>

            <section class="events">
                @forelse($featuredEvents as $event)
                    <article class="event"><h3>{{ $event['title'] }}</h3><p>{{ $event['event_date'] }} · {{ $event['venue_name'] ?? 'Площадка уточняется' }}</p></article>
                @empty
                    <article class="event"><h3>Вечеринки</h3><p>Музыка, интерактивы и лёгкая импровизация.</p></article>
                    <article class="event"><h3>Свадьбы</h3><p>Тёплая церемония и энергичный банкет.</p></article>
                    <article class="event"><h3>Корпоративы</h3><p>Командный ритм и понятный сценарий.</p></article>
                @endforelse
            </section>
        </div>
    </main>
</body>
</html>
