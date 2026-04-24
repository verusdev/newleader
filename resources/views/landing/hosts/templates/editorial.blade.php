<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant->name }} - event host</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --paper: #fff1d6; --ink: #171717; --red: #e11d48; --blue: #2563eb; --sun: #facc15; --line: rgba(23,23,23,.18); }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--paper); color: var(--ink); font-family: Montserrat, sans-serif; }
        .page { min-height: 100vh; padding: 28px; background-image: radial-gradient(circle at 12% 16%, rgba(225,29,72,.26), transparent 24%), radial-gradient(circle at 88% 18%, rgba(37,99,235,.22), transparent 26%), linear-gradient(var(--line) 1px, transparent 1px), linear-gradient(90deg, var(--line) 1px, transparent 1px); background-size: auto, auto, 72px 72px, 72px 72px; }
        .shell { max-width: 1200px; margin: 0 auto; border: 2px solid var(--ink); background: rgba(255,241,214,.92); box-shadow: 18px 18px 0 var(--sun), 34px 34px 0 var(--blue); }
        header { display: flex; justify-content: space-between; border-bottom: 2px solid var(--ink); padding: 18px 24px; text-transform: uppercase; font-size: 13px; letter-spacing: .16em; }
        .hero { display: grid; grid-template-columns: 1.2fr .8fr; min-height: 560px; }
        .copy { padding: 58px 42px; border-right: 2px solid var(--ink); }
        h1 { font-family: "Cormorant Garamond", serif; font-size: clamp(58px, 10vw, 132px); line-height: .82; margin: 0; letter-spacing: -.06em; }
        .sub { margin-top: 28px; font-size: 18px; line-height: 1.8; max-width: 620px; }
        .side { padding: 34px; display: flex; flex-direction: column; justify-content: space-between; background: linear-gradient(160deg, var(--red), #7c2d12 58%, var(--blue)); color: white; }
        .side strong { font-family: "Cormorant Garamond", serif; font-size: 72px; display: block; }
        .contact { color: var(--ink); background: var(--sun); display: inline-block; padding: 14px 20px; text-decoration: none; font-weight: 800; margin-top: 22px; box-shadow: 8px 8px 0 var(--red); }
        .strip { display: grid; grid-template-columns: repeat(4, 1fr); border-top: 2px solid var(--ink); }
        .strip div { padding: 22px; border-right: 2px solid var(--ink); min-height: 120px; }
        .strip div:last-child { border-right: 0; }
        @media (max-width: 850px) { .hero, .strip { grid-template-columns: 1fr; } .copy { border-right: 0; border-bottom: 2px solid var(--ink); } .strip div { border-right: 0; border-bottom: 2px solid var(--ink); } }
    </style>
</head>
<body>
    <div class="page">
        <main class="shell">
            <header>
                <span>{{ $tenant->name }}</span>
                <span>Private events / weddings / corporate</span>
            </header>
            <section class="hero">
                <div class="copy">
                    <h1>Событие как обложка журнала</h1>
                    <p class="sub">Премиальная подача для ведущего: сильная типографика, ощущение редакционного портфолио и фокус на статусных мероприятиях.</p>
                    <a class="contact" href="mailto:{{ $tenant->email }}">Запросить свободную дату</a>
                </div>
                <aside class="side">
                    <div>
                        <strong>{{ $stats['events'] }}</strong>
                        событий в работе
                    </div>
                    <div>
                        <p>Гости: {{ $stats['guests'] }}</p>
                        <p>Партнёры: {{ $stats['vendors'] }}</p>
                        <p>Бюджет: {{ number_format($stats['budget'], 0, '.', ' ') }} ₽</p>
                    </div>
                </aside>
            </section>
            <section class="strip">
                @forelse($featuredEvents as $event)
                    <div><strong>{{ $event['title'] }}</strong><br>{{ $event['event_date'] }}</div>
                @empty
                    <div><strong>Свадьбы</strong><br>Сценарий, эмоции, тайминг.</div>
                    <div><strong>Премии</strong><br>Сценическая подача.</div>
                    <div><strong>Корпоративы</strong><br>Деловой тон без скуки.</div>
                    <div><strong>Частные вечера</strong><br>Тонкая работа с гостями.</div>
                @endforelse
            </section>
        </main>
    </div>
</body>
</html>
