# Архитектура

## Обзор

Система разделена на четыре логические части:

1. central приложение;
2. tenant CRM;
3. публичный лендинг ведущего;
4. публичный invitation landing мероприятия.

Проект использует `stancl/tenancy` по схеме: одна central база и одна отдельная база на каждого tenant-а.

## Central приложение

Central часть отвечает за:

- SaaS-лендинг;
- оформление подписки;
- callback и webhook платежей;
- управление tenant-ами;
- управление подписками.

Основные central сущности:

- `Tenant`
- `Domain`
- `Subscription`
- `SubscriptionPlan`

Основные файлы:

- [../routes/web.php](../routes/web.php)
- [../app/Http/Controllers/LandingController.php](../app/Http/Controllers/LandingController.php)
- [../app/Http/Controllers/Central/TenantController.php](../app/Http/Controllers/Central/TenantController.php)
- [../app/Http/Controllers/Central/SubscriptionController.php](../app/Http/Controllers/Central/SubscriptionController.php)

## Tenant CRM

Tenant CRM доступна по пути:

`/tenant/{tenant-id}`

Tenancy инициализируется через `InitializeTenancyByPath`.

Сейчас внутри tenant CRM есть:

- дашборд;
- лиды и клиенты;
- pipeline и таймлайн сделки;
- мероприятия;
- календарь мероприятий;
- гости;
- задачи;
- бюджет;
- подрядчики.

Tenant-маршруты описаны в [../routes/tenant.php](../routes/tenant.php).

## Логика лида и клиента

В проекте лид и клиент живут в одной сущности `Client`.

Принцип работы:

- новый контакт создаётся как `lead`;
- уже при создании фиксируется бриф по конкретному мероприятию;
- создаётся набор timeline steps;
- по завершении этапа `contract_signed` контакт автоматически становится `client`.

Таймлайн хранится в:

- [../app/Models/Client.php](../app/Models/Client.php)
- [../app/Models/ClientTimelineStep.php](../app/Models/ClientTimelineStep.php)

Основной контроллер:

- [../app/Http/Controllers/Tenant/ClientController.php](../app/Http/Controllers/Tenant/ClientController.php)

## Мероприятия

Каждое мероприятие связано с клиентом или лидом и хранит:

- название;
- тип;
- дату и время;
- площадку и адрес;
- ожидаемое число гостей;
- бюджет;
- описание;
- статус;
- `invitation_token`.

События отображаются:

- в списке мероприятий;
- в календаре;
- в карточке клиента;
- в публичном invitation landing.

Основные файлы:

- [../app/Models/Event.php](../app/Models/Event.php)
- [../app/Http/Controllers/Tenant/EventController.php](../app/Http/Controllers/Tenant/EventController.php)
- [../resources/views/tenant/events/calendar.blade.php](../resources/views/tenant/events/calendar.blade.php)

## Гости и RSVP

Гости принадлежат конкретному мероприятию.

Для гостя сейчас доступны:

- имя;
- email;
- телефон;
- категория;
- подтверждение;
- `rsvp_status`;
- `responded_at`;
- `plus_one`;
- `notes`;
- `invitation_token`.

Механика RSVP:

- у события есть общий invitation URL;
- у гостя есть персональная invitation URL;
- RSVP отправляется через публичную форму;
- ответ сохраняется в tenant CRM.

Основные файлы:

- [../app/Models/Guest.php](../app/Models/Guest.php)
- [../app/Http/Controllers/PublicInvitationController.php](../app/Http/Controllers/PublicInvitationController.php)
- [../resources/views/landing/invitation/show.blade.php](../resources/views/landing/invitation/show.blade.php)
- [../resources/views/tenant/guests/index.blade.php](../resources/views/tenant/guests/index.blade.php)

## Публичный лендинг ведущего

У каждого tenant-а есть отдельная публичная promo-страница:

`/hosts/{tenant-id}`

Страница:

- находит tenant в central базе;
- инициализирует tenant-контекст;
- читает tenant-статистику;
- рендерит один из шаблонов дизайна.

Доступные шаблоны:

- `classic`
- `editorial`
- `neon`

Основные файлы:

- [../app/Http/Controllers/PublicHostLandingController.php](../app/Http/Controllers/PublicHostLandingController.php)
- [../app/Models/Tenant.php](../app/Models/Tenant.php)
- [../resources/views/landing/hosts/templates](../resources/views/landing/hosts/templates)

## Invitation landing мероприятия

У каждого мероприятия есть публичная страница приглашения:

- `/invite/{tenant}/{eventToken}`
- `/invite/{tenant}/{eventToken}/{guestToken}`

Эта страница:

- находит tenant в central базе;
- инициализирует tenant-контекст;
- находит событие по `invitation_token`;
- при наличии `guestToken` находит конкретного гостя;
- отображает публичную страницу мероприятия;
- принимает RSVP через POST.

Важно:

- tenant-контекст должен жить до конца рендера Blade, иначе Eloquent casts могут потребовать соединение `tenant` после `tenancy()->end()`.

## Tenancy configuration

Основная конфигурация находится в:

- [../config/tenancy.php](../config/tenancy.php)

Текущее состояние:

- path identification включён;
- database bootstrapper включён;
- cache bootstrapper включён;
- queue bootstrapper включён;
- filesystem bootstrapper отключён для текущего demo.

## Хранение данных

Central БД:

- `database/database.sqlite`

Tenant БД:

- `database/tenant{tenant-id}`

Tenant миграции:

- [../database/migrations/tenant](../database/migrations/tenant)

## Demo-наполнение

Для воспроизводимого наполнения tenant БД используется:

- [../scripts/refresh_demo_data.php](../scripts/refresh_demo_data.php)

Скрипт:

- очищает tenant-данные;
- создаёт корректные русские demo-сущности;
- наполняет лиды, клиентов, мероприятия, гостей, задачи, бюджет и подрядчиков.

## Эксплуатационные заметки

- Tenant SQLite-файлы относятся к данным окружения и не должны коммититься.
- Публичный host landing устойчив к отсутствующей tenant БД.
- Invitation landing зависит от корректной tenant БД и invite token-ов.
- Для локального показа path-based tenancy проще и надёжнее, чем subdomain tenancy.
