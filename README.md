# Event CRM

Мультитенантная SaaS CRM для ведущих и организаторов мероприятий.

Проект объединяет:

- центральный маркетинговый лендинг и оформление подписки;
- админку для управления tenant-ами и подписками;
- tenant CRM для ежедневной операционной работы;
- публичный рекламный лендинг каждого ведущего;
- публичный лендинг-приглашение для каждого мероприятия с RSVP.

Интерфейс построен на Blade и AdminLTE 3. Мультитенантность реализована через `stancl/tenancy`.

## Стек

- PHP `^8.3`
- Laravel `^13`
- `stancl/tenancy` `^3.10`
- `yoomoney/yookassa-sdk-php` `^3.13`
- Vite `^8`
- AdminLTE 3
- SQLite для central и tenant БД в локальном demo-окружении

## Что уже реализовано

### Central app

- главный SaaS-лендинг `/`
- оформление подписки
- callback и webhook платежей
- админка tenant-ов `/admin/tenants`
- админка подписок `/admin/subscriptions`

### Tenant CRM

Каждый tenant работает в отдельной БД и открывается по path tenancy:

`/tenant/{tenant-id}`

В CRM сейчас есть:

- дашборд
- клиенты и лиды
- pipeline лида с таймлайном этапов
- мероприятия
- календарь мероприятий
- гости
- задачи
- бюджет
- подрядчики

### Публичные страницы

- рекламный лендинг ведущего: `/hosts/{tenant-id}`
- лендинг-приглашение мероприятия: `/invite/{tenant-id}/{eventToken}`
- персональное приглашение гостя: `/invite/{tenant-id}/{eventToken}/{guestToken}`

## Бизнес-логика CRM

### Лиды и клиенты

CRM построена вокруг процесса продажи мероприятия:

1. сначала создаётся лид;
2. уже на этапе лида фиксируется бриф по конкретному мероприятию;
3. для лида создаётся таймлайн этапов;
4. после завершения этапа `contract_signed` лид автоматически становится клиентом.

Текущие этапы таймлайна:

- `incoming_call` — первичный звонок
- `meeting` — встреча / бриф
- `contract_signed` — заключение договора
- `equipment_prep` — подготовка оборудования
- `event_prep` — финальная подготовка
- `event_day` — день мероприятия
- `follow_up` — постконтакт / обратная связь

### Мероприятия

Мероприятие создаётся уже при появлении лида и содержит:

- название
- тип
- дату
- время
- площадку
- адрес
- ожидаемое число гостей
- бюджет
- комментарий

### Приглашения и RSVP

У каждого мероприятия есть публичный invitation landing.

Возможности:

- общая ссылка на мероприятие для приглашения гостей;
- персональные ссылки для каждого гостя;
- форма RSVP прямо на лендинге;
- сохранение ответа в tenant CRM;
- поля RSVP: статус ответа, дата ответа, `+1`, комментарий.

## Архитектура tenancy

Проект использует `stancl/tenancy` по схеме:

- одна central SQLite база: `database/database.sqlite`;
- одна отдельная SQLite база на каждого tenant-а;
- tenant БД создаются в формате `database/tenant{tenant-id}`;
- tenant CRM определяется через path-based tenancy.

Ключевые файлы:

- [config/tenancy.php](config/tenancy.php)
- [app/Providers/TenancyServiceProvider.php](app/Providers/TenancyServiceProvider.php)
- [app/Models/Tenant.php](app/Models/Tenant.php)
- [app/Http/Middleware/SetTenantRouteParameter.php](app/Http/Middleware/SetTenantRouteParameter.php)

## Публичные шаблоны лендинга ведущего

Для страницы `/hosts/{tenant}` доступны шаблоны:

- `classic`
- `editorial`
- `neon`

Выбранный шаблон хранится в метаданных tenant-а.

## Установка

### 1. Установить зависимости

```bash
composer install
npm install
```

### 2. Подготовить окружение

Проверьте минимум такие параметры в `.env`:

```env
APP_NAME="Event CRM"
APP_ENV=local
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

YOOKASSA_SHOP_ID=your_shop_id
YOOKASSA_SECRET_KEY=your_secret_key
```

### 3. Создать central SQLite базу

Windows:

```bash
type nul > database/database.sqlite
```

Unix:

```bash
touch database/database.sqlite
```

### 4. Выполнить миграции и сиды central app

```bash
php artisan migrate
php artisan db:seed --class=SubscriptionPlanSeeder
```

### 5. Запустить приложение

```bash
php artisan serve
```

Опционально:

```bash
npm run dev
```

## Demo-данные

Для локального demo-наполнения tenant БД есть скрипт:

- [scripts/refresh_demo_data.php](scripts/refresh_demo_data.php)

Запуск:

```bash
php scripts/refresh_demo_data.php
```

Скрипт:

- обновляет имена demo tenant-ов;
- очищает tenant-данные;
- создаёт корректные русские demo-данные;
- наполняет лиды, клиентов, мероприятия, гостей, задачи, бюджет и подрядчиков;
- создаёт demo-ссылки для публичных лендингов и RSVP.

## Полезные команды

```bash
php artisan test
npm run build
php artisan route:list
php artisan tenants:migrate
php scripts/refresh_demo_data.php
```

Из `composer.json`:

```bash
composer run setup
composer run dev
composer run test
```

## Demo URL

При локальном запуске на `127.0.0.1:8000`:

- SaaS-лендинг: `http://127.0.0.1:8000/`
- tenant admin: `http://127.0.0.1:8000/admin/tenants`
- subscriptions admin: `http://127.0.0.1:8000/admin/subscriptions`

Примеры:

- CRM Ирины: `http://127.0.0.1:8000/tenant/906a4463-2114-4c3d-aa8d-d198c7727be9`
- лендинг Ирины: `http://127.0.0.1:8000/hosts/906a4463-2114-4c3d-aa8d-d198c7727be9`
- CRM Алексея: `http://127.0.0.1:8000/tenant/96786bbd-3a80-4f1f-95c0-c39947c15b46`
- лендинг Алексея: `http://127.0.0.1:8000/hosts/96786bbd-3a80-4f1f-95c0-c39947c15b46`

Invitation examples:

- общее приглашение мероприятия: `http://127.0.0.1:8000/invite/{tenant-id}/{eventToken}`
- персональное приглашение гостя: `http://127.0.0.1:8000/invite/{tenant-id}/{eventToken}/{guestToken}`

## Технические заметки

- Используется path tenancy, а не subdomain tenancy.
- Filesystem tenancy bootstrapper отключён в [config/tenancy.php](config/tenancy.php), чтобы не ломать публичные страницы в текущем demo-режиме.
- Публичный лендинг ведущего устойчив к отсутствующей tenant БД и в таком случае рендерится с пустой статистикой.
- Публичный invitation landing требует активного tenant-контекста до завершения рендера Blade.
- Tenant SQLite-файлы относятся к данным окружения и не должны храниться в репозитории.

## Ключевые файлы

- [routes/web.php](routes/web.php)
- [routes/tenant.php](routes/tenant.php)
- [config/tenancy.php](config/tenancy.php)
- [app/Http/Controllers/PublicHostLandingController.php](app/Http/Controllers/PublicHostLandingController.php)
- [app/Http/Controllers/PublicInvitationController.php](app/Http/Controllers/PublicInvitationController.php)
- [app/Http/Controllers/Tenant/ClientController.php](app/Http/Controllers/Tenant/ClientController.php)
- [app/Http/Controllers/Tenant/EventController.php](app/Http/Controllers/Tenant/EventController.php)
- [app/Models/Tenant.php](app/Models/Tenant.php)
- [scripts/refresh_demo_data.php](scripts/refresh_demo_data.php)

## Дополнительная документация

- [Архитектура](docs/architecture.md)
- [Маршруты](docs/routes.md)
- [Демо-сценарий](docs/demo.md)

## Лицензия

MIT
