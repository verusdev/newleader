@extends('layouts.landing')

@section('title', 'NewLeader CRM для ведущих и организаторов')

@section('content')
<section class="system-hero">
    <div class="hero-glow hero-glow-one"></div>
    <div class="hero-glow hero-glow-two"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="hero-kicker">CRM для событий, продаж и команды</div>
                <h1 class="hero-title">Праздники выглядят ярко. Управление ими тоже.</h1>
                <p class="hero-lead">
                    NewLeader собирает заявки, сделки, гостей, бюджет, задачи и лендинги ведущих в одной системе,
                    чтобы подготовка мероприятия не превращалась в хаос из таблиц и переписок.
                </p>
                <div class="hero-actions">
                    <a href="#plans" class="btn btn-sun btn-lg">
                        <i class="fas fa-rocket mr-2"></i>Выбрать тариф
                    </a>
                    <a href="#features" class="btn btn-glass btn-lg">
                        <i class="fas fa-play-circle mr-2"></i>Посмотреть возможности
                    </a>
                </div>
                <div class="hero-points">
                    <span><i class="fas fa-check"></i> сделки и таймлайн</span>
                    <span><i class="fas fa-check"></i> RSVP и гости</span>
                    <span><i class="fas fa-check"></i> бюджет и подрядчики</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-collage">
                    <img class="hero-photo hero-photo-main" src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=980&q=80" alt="Зал мероприятия с праздничным светом">
                    <img class="hero-photo hero-photo-small" src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=620&q=80" alt="Концертная сцена с ярким светом">
                    <div class="dashboard-card">
                        <div class="dashboard-top">
                            <span>Сегодня</span>
                            <strong>7 задач</strong>
                        </div>
                        <div class="dashboard-line line-pink"></div>
                        <div class="dashboard-line line-blue"></div>
                        <div class="dashboard-line line-green"></div>
                        <div class="dashboard-note">Свадьба · договор подписан · гости подтверждаются</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="showcase-strip">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-tile"><strong>1</strong><span>единое рабочее место</span></div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-tile"><strong>5</strong><span>шаблонов лендинга ведущего</span></div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-tile"><strong>24/7</strong><span>доступ к данным события</span></div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-tile"><strong>0</strong><span>потерянных договорённостей</span></div>
            </div>
        </div>
    </div>
</section>

<section class="feature-gallery" id="features">
    <div class="container">
        <div class="section-heading">
            <span>Что внутри</span>
            <h2>Система закрывает весь путь от заявки до финального отчёта</h2>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <article class="feature-card feature-hot">
                    <img src="https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&w=720&q=80" alt="Украшенный банкетный стол">
                    <div class="feature-body">
                        <i class="fas fa-route"></i>
                        <h3>Сделки и этапы</h3>
                        <p>Ведите лидов по понятному таймлайну: бриф, КП, договор, подготовка, финальное сопровождение.</p>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 mb-4">
                <article class="feature-card feature-cool">
                    <img src="https://images.unsplash.com/photo-1505236858219-8359eb29e329?auto=format&fit=crop&w=720&q=80" alt="Гости на мероприятии">
                    <div class="feature-body">
                        <i class="fas fa-users"></i>
                        <h3>Гости и RSVP</h3>
                        <p>Списки гостей, ответы на приглашения, плюс-один, заметки и быстрый контроль подтверждений.</p>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 mb-4">
                <article class="feature-card feature-green">
                    <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?auto=format&fit=crop&w=720&q=80" alt="Праздничный зал с огнями">
                    <div class="feature-body">
                        <i class="fas fa-wallet"></i>
                        <h3>Бюджет и подрядчики</h3>
                        <p>Фиксируйте сметы, фактические оплаты, дедлайны, подрядчиков и ответственных по каждому событию.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="workflow-section">
    <div class="container">
        <div class="workflow-panel">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <img class="workflow-image" src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=900&q=80" alt="Яркое мероприятие с конфетти">
                </div>
                <div class="col-lg-7">
                    <span class="section-label">Без разрозненных таблиц</span>
                    <h2>Команда видит один сценарий подготовки</h2>
                    <div class="workflow-list">
                        <div><strong>01</strong><span>Создаёте лида и бриф мероприятия сразу при первой заявке.</span></div>
                        <div><strong>02</strong><span>Двигаете сделку по этапам и сохраняете договорённости в таймлайне.</span></div>
                        <div><strong>03</strong><span>Ведёте задачи, гостей, бюджет и подрядчиков до дня события.</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="plans-section" id="plans">
    <div class="container">
        <div class="section-heading text-center">
            <span>Тарифы</span>
            <h2>Выберите темп роста для своей команды</h2>
        </div>
        <div class="row">
            @foreach($plans as $plan)
                <div class="col-md-4 mb-4">
                    <div class="card pricing-card h-100">
                        <div class="card-header text-center">
                            <div class="plan-orbit"></div>
                            <h3 class="card-title mb-0">{{ $plan->name }}</h3>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="mb-2">
                                <span class="display-4 font-weight-bold">{{ number_format($plan->price, 0) }}</span>
                                <span class="text-muted">₽/{{ $plan->interval === 'month' ? 'мес' : 'год' }}</span>
                            </h2>
                            <p class="text-muted mb-4">{{ $plan->description }}</p>
                            <ul class="list-unstyled text-left mb-4">
                                @if(is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>{{ $feature }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('landing.checkout', $plan) }}" class="btn btn-gradient btn-lg btn-block">
                                Выбрать тариф
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
