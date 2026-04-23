# Event CRM

Мультитенантная SaaS CRM для ведущих и организаторов мероприятий. Проект объединяет:

- центральный лендинг и биллинг,
- админку для управления tenant-ами и подписками,
- tenant CRM для операционной работы,
- публичный рекламный лендинг каждого ведущего,
- несколько шаблонов дизайна для такого лендинга.

Интерфейс построен на Blade и AdminLTE 3. Мультитенантность реализована через `stancl/tenancy`.

## Стек

- PHP `^8.3`
- Laravel `^13`
- `stancl/tenancy` `^3.10`
- `yoomoney/yookassa-sdk-php` `^3.13`
- Vite `^8`
- AdminLTE 3

## Основные зоны продукта

### Центральная часть

Центральное приложение работает на основном домене и содержит:

- главный SaaS-лендинг `/`
- оформление подписки
- обработку callback и webhook платежей
- админку tenant-ов `/admin/tenants`
- админку подписок `/admin/subscriptions`

Маршруты описаны в [routes/web.php](routes/web.php).

### Tenant CRM

Каждый tenant получает отдельную базу данных и CRM по path tenancy:

`/tenant/{tenant-id}`

Tenant-маршруты описаны в [routes/tenant.php](routes/tenant.php).

Текущие разделы CRM:

- дашборд
- мероприятия
- клиенты
- гости
- задачи
- бюджет
- подрядчики

### Публичный лендинг ведущего

У каждого tenant-а есть отдельная рекламная страница:

`/hosts/{tenant-id}`

Эта страница предназначена для продвижения ведущего, презентации услуг и получения лидов. Дизайн можно переключать из админки.

Доступные шаблоны:

- `classic`
- `editorial`
- `neon`

Шаблоны лежат в [resources/views/landing/hosts/templates](resources/views/landing/hosts/templates).

## Архитектура

### Модель мультитенантности

Проект использует `stancl/tenancy` со следующей схемой:

- центральная база для tenant-ов, доменов, подписок, тарифов и платежей
- отдельная база на каждого tenant-а
- path-based идентификация tenant-а через `/tenant/{tenant}`

Ключевые файлы:

- [config/tenancy.php](config/tenancy.php)
- [app/Providers/TenancyServiceProvider.php](app/Providers/TenancyServiceProvider.php)
- [app/Models/Tenant.php](app/Models/Tenant.php)
- [app/Http/Middleware/SetTenantRouteParameter.php](app/Http/Middleware/SetTenantRouteParameter.php)

### Базы данных

Центральная SQLite база:

- `database/database.sqlite`

Tenant-базы создаются автоматически в формате:

- `database/tenant{tenant-id}`

Tenant-миграции лежат в:

- [database/migrations/tenant](database/migrations/tenant)

Центральные миграции лежат в:

- [database/migrations](database/migrations)

### Метаданные tenant-а

Кастомная модель tenant-а расширяет базовую модель `stancl/tenancy` и хранит дополнительные поля в JSON-колонке `data`.

Примеры:

- `name`
- `email`
- `landing_template`

## Основные сценарии

### Сценарий подписки

1. Пользователь открывает `/`
2. Выбирает тариф
3. Вводит имя, email и tenant domain
4. В центральной базе создаётся подписка
5. Создаётся платёж через YooKassa или выполняется локальная автoактивация
6. Создаётся tenant
7. Создаётся и мигрируется tenant-база
8. Пользователь получает доступ к CRM

Ключевые файлы:

- [app/Http/Controllers/LandingController.php](app/Http/Controllers/LandingController.php)
- [app/Services/SubscriptionService.php](app/Services/SubscriptionService.php)

### Сценарий управления tenant-ом

Администратор может:

- создать tenant вручную
- открыть tenant CRM
- открыть публичный лендинг ведущего
- сменить шаблон лендинга
- удалить tenant

Ключевые файлы:

- [app/Http/Controllers/Central/TenantController.php](app/Http/Controllers/Central/TenantController.php)
- [resources/views/central/tenants/index.blade.php](resources/views/central/tenants/index.blade.php)
- [resources/views/central/tenants/show.blade.php](resources/views/central/tenants/show.blade.php)

### Сценарий публичного лендинга

Публичная страница:

- находит tenant в центральной базе
- инициализирует tenant-контекст
- читает статистику из tenant-базы
- рендерит выбранный шаблон
- не падает, даже если tenant-база ещё не создана

Ключевой файл:

- [app/Http/Controllers/PublicHostLandingController.php](app/Http/Controllers/PublicHostLandingController.php)

## Структура проекта

```text
app/
  Http/
    Controllers/
      Central/
      Tenant/
  Models/
  Providers/
  Services/

bootstrap/
config/
database/
  migrations/
  migrations/tenant/
  seeders/

resources/
  views/
    central/
    landing/
    tenant/
    layouts/

routes/
  web.php
  tenant.php
```

## Установка

### 1. Установить зависимости

```bash
composer install
npm install
```

### 2. Подготовить окружение

При необходимости скопируйте `.env.example` в `.env`, затем проверьте минимум такие параметры:

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

### 3. Создать центральную SQLite базу

Если файл ещё не существует:

```bash
type nul > database/database.sqlite
```

Для Unix-подобных систем:

```bash
touch database/database.sqlite
```

### 4. Выполнить миграции и сиды

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

## Полезные команды

Из [composer.json](composer.json):

```bash
composer run setup
composer run dev
composer run test
```

Запуск тестов:

```bash
php artisan test
```

Сборка фронтенда:

```bash
npm run build
```

## Демо URL

При локальном запуске на `127.0.0.1:8000`:

- главный лендинг: `http://127.0.0.1:8000/`
- список tenant-ов: `http://127.0.0.1:8000/admin/tenants`
- список подписок: `http://127.0.0.1:8000/admin/subscriptions`

Пример tenant CRM:

- `http://127.0.0.1:8000/tenant/96786bbd-3a80-4f1f-95c0-c39947c15b46`

Пример публичного лендинга ведущего:

- `http://127.0.0.1:8000/hosts/96786bbd-3a80-4f1f-95c0-c39947c15b46`

## Шаблоны лендинга ведущего

Шаблон выбирается из админки tenant-а.

Текущие варианты:

- `classic` — спокойная премиальная подача
- `editorial` — журнальная, более статусная визуальная подача
- `neon` — яркий промо-лендинг для активной рекламы

Выбранный шаблон хранится в метаданных tenant-а и определяется через [app/Models/Tenant.php](app/Models/Tenant.php).

## Технические заметки

- Сейчас используется path tenancy, а не subdomain tenancy.
- Filesystem tenancy bootstrapper специально отключён в [config/tenancy.php](config/tenancy.php), потому что в текущем демо tenant-загрузки файлов не используются, а bootstrapper вызывал ошибки на публичных страницах.
- Публичные лендинги ведущих устойчивы к отсутствующей tenant-базе и в этом случае рендерятся с пустой статистикой.
- Tenant SQLite-файлы являются данными окружения и игнорируются через `/database/tenant*`.
- В кодовой базе ещё могут встречаться старые файлы со смешанной историей кодировки русского текста. Новая документация и обновлённые админские экраны записаны в UTF-8.

## Важные файлы

- bootstrap приложения: [bootstrap/app.php](bootstrap/app.php)
- провайдеры: [bootstrap/providers.php](bootstrap/providers.php)
- central routes: [routes/web.php](routes/web.php)
- tenant routes: [routes/tenant.php](routes/tenant.php)
- tenancy config: [config/tenancy.php](config/tenancy.php)
- сервис подписок: [app/Services/SubscriptionService.php](app/Services/SubscriptionService.php)
- контроллер публичного лендинга: [app/Http/Controllers/PublicHostLandingController.php](app/Http/Controllers/PublicHostLandingController.php)
- админский контроллер tenant-ов: [app/Http/Controllers/Central/TenantController.php](app/Http/Controllers/Central/TenantController.php)
- модель tenant-а: [app/Models/Tenant.php](app/Models/Tenant.php)

## Дополнительная документация

- [Архитектура](docs/architecture.md)
- [Маршруты](docs/routes.md)
- [Демо-сценарий](docs/demo.md)

## Лицензия

MIT
