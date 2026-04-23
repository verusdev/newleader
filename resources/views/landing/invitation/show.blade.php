<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - приглашение</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Manrope:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #1d2734;
            --accent: #d6a85f;
            --bg: #f7f2ea;
            --panel: rgba(255,255,255,.85);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Manrope, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(214,168,95,.28), transparent 28%),
                linear-gradient(135deg, #fdf8f1, var(--bg));
        }
        .wrap { max-width: 1180px; margin: 0 auto; padding: 36px 20px 64px; }
        .hero {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 28px;
            align-items: start;
        }
        .card, .panel {
            background: var(--panel);
            border: 1px solid rgba(29,39,52,.08);
            border-radius: 30px;
            box-shadow: 0 24px 80px rgba(29,39,52,.08);
        }
        .card { padding: 42px; }
        .eyebrow {
            text-transform: uppercase;
            letter-spacing: .18em;
            font-size: 12px;
            font-weight: 700;
            color: #85704a;
        }
        h1 {
            font-family: "Cormorant Garamond", serif;
            font-size: clamp(46px, 8vw, 88px);
            line-height: .92;
            margin: 14px 0 20px;
        }
        .lead {
            font-size: 19px;
            line-height: 1.8;
            color: #5f6875;
            max-width: 650px;
        }
        .facts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 28px;
        }
        .fact {
            background: rgba(255,255,255,.72);
            border-radius: 20px;
            padding: 18px 20px;
        }
        .fact strong {
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            color: #8d774f;
            margin-bottom: 8px;
        }
        .panel { padding: 28px; }
        .panel h2 {
            margin: 0 0 16px;
            font-size: 26px;
        }
        .guest-note {
            margin: 0 0 18px;
            padding: 14px 16px;
            background: rgba(214,168,95,.12);
            border-radius: 16px;
            font-size: 14px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
            font-size: 14px;
        }
        input, textarea, select {
            width: 100%;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1px solid rgba(29,39,52,.15);
            background: white;
            font: inherit;
        }
        textarea { min-height: 90px; resize: vertical; }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
        .actions { margin-top: 18px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        button {
            border: 0;
            border-radius: 16px;
            padding: 14px 20px;
            background: var(--ink);
            color: white;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }
        .secondary {
            color: #617080;
            font-size: 14px;
        }
        .flash {
            margin-bottom: 16px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #e8f6ea;
            color: #1c6631;
            font-weight: 600;
        }
        .errors {
            margin-bottom: 16px;
            padding: 14px 18px;
            border-radius: 16px;
            background: #fff0f0;
            color: #8f2d2d;
        }
        @media (max-width: 860px) {
            .hero, .grid, .facts { grid-template-columns: 1fr; }
            .card, .panel { padding: 24px; }
        }
    </style>
</head>
<body>
<main class="wrap">
    <section class="hero">
        <div class="card">
            <div class="eyebrow">Приглашение от {{ $tenant->name }}</div>
            <h1>{{ $event->title }}</h1>
            <p class="lead">
                Будем рады видеть вас на нашем мероприятии. Пожалуйста, подтвердите участие через форму RSVP.
            </p>

            <div class="facts">
                <div class="fact">
                    <strong>Дата</strong>
                    {{ $event->event_date->format('d.m.Y') }}
                </div>
                <div class="fact">
                    <strong>Время</strong>
                    {{ $event->event_time ?: 'Уточняется' }}
                </div>
                <div class="fact">
                    <strong>Площадка</strong>
                    {{ $event->venue_name ?: 'Будет сообщена отдельно' }}
                </div>
                <div class="fact">
                    <strong>Адрес</strong>
                    {{ $event->venue_address ?: 'Будет сообщён отдельно' }}
                </div>
            </div>

            @if($event->description)
                <div style="margin-top: 24px; color: #5f6875; line-height: 1.7;">
                    {{ $event->description }}
                </div>
            @endif
        </div>

        <div class="panel">
            <h2>RSVP</h2>

            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="errors">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($guest)
                <p class="guest-note">
                    Приглашение открыто для гостя: <strong>{{ $guest->name }}</strong>
                </p>
            @endif

            <form method="POST" action="{{ route('invitation.rsvp', ['tenant' => $tenant->id, 'eventToken' => $event->invitation_token, 'guestToken' => $guest?->invitation_token]) }}">
                @csrf

                <div class="grid">
                    <div>
                        <label for="name">Имя</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $guest?->name) }}" required>
                    </div>
                    <div>
                        <label for="phone">Телефон</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $guest?->phone) }}">
                    </div>
                </div>

                <div style="margin-top: 14px;">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $guest?->email) }}">
                </div>

                <div class="grid" style="margin-top: 14px;">
                    <div>
                        <label for="attendance">Ваш ответ</label>
                        <select id="attendance" name="attendance" required>
                            <option value="confirmed" @selected(old('attendance', $guest?->rsvp_status) === 'confirmed')>Буду</option>
                            <option value="declined" @selected(old('attendance', $guest?->rsvp_status) === 'declined')>Не смогу</option>
                        </select>
                    </div>
                    <div>
                        <label for="plus_one">Сопровождающих</label>
                        <input id="plus_one" name="plus_one" type="number" min="0" max="10" value="{{ old('plus_one', $guest?->plus_one ?? 0) }}">
                    </div>
                </div>

                <div style="margin-top: 14px;">
                    <label for="notes">Комментарий</label>
                    <textarea id="notes" name="notes">{{ old('notes', $guest?->notes) }}</textarea>
                </div>

                <div class="actions">
                    <button type="submit">Отправить RSVP</button>
                    <span class="secondary">Ваш ответ будет сохранён в CRM организатора.</span>
                </div>
            </form>
        </div>
    </section>
</main>
</body>
</html>
