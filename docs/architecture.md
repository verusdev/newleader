# Архитектура

## Обзор

Система разделена на три логические части:

1. Центральное приложение
2. Tenant CRM
3. Публичный лендинг ведущего

Проект использует `stancl/tenancy` по схеме: одна центральная база и одна отдельная база на каждого tenant-а.

## Центральное приложение

Центральная часть отвечает за:

- маркетинговый лендинг
- оформление подписки
- callback и webhook платежей
- администрирование tenant-ов
- администрирование подписок

Central HTTP routes описаны в [../routes/web.php](../routes/web.php).

Основные центральные сущности:

- `Tenant`
- `Domain`
- `Subscription`
- `CentralSubscriptionPlan`
- `CentralPayment`

## Tenant CRM

Tenant CRM доступна по пути:

`/tenant/{tenant-id}`

Инициализация tenancy выполняется через `InitializeTenancyByPath`.

Внутри tenant CRM сейчас есть:

- дашборд
- мероприятия
- клиенты
- гости
- задачи
- бюджет
- подрядчики

Tenant-маршруты описаны в [../routes/tenant.php](../routes/tenant.php).

Хранилище tenant-данных:

- у каждого tenant-а отдельный SQLite файл
- формат имени базы: `tenant{tenant-id}`
- tenant-миграции лежат в [../database/migrations/tenant](../database/migrations/tenant)

## Публичный лендинг ведущего

У каждого tenant-а есть отдельная публичная страница:

`/hosts/{tenant-id}`

Эта страница:

- находит tenant в центральной базе
- инициализирует tenant-контекст
- читает статистику из tenant-базы
- рендерит один из шаблонов дизайна

Ключевой файл:

- [../app/Http/Controllers/PublicHostLandingController.php](../app/Http/Controllers/PublicHostLandingController.php)

## Конфигурация tenancy

Основная конфигурация находится в:

- [../config/tenancy.php](../config/tenancy.php)

Текущее состояние:

- path identification включён
- database bootstrapper включён
- cache bootstrapper включён
- queue bootstrapper включён
- filesystem bootstrapper отключён для текущего демо

## Метаданные tenant-а

Кастомная модель tenant-а хранится в центральной базе и расширяет базовую модель `stancl/tenancy`.

Дополнительные атрибуты лежат в JSON-колонке `data`:

- `name`
- `email`
- `landing_template`

Ключевой файл:

- [../app/Models/Tenant.php](../app/Models/Tenant.php)

## Генерация tenant-маршрутов

В tenant CRM используется middleware, которое автоматически подставляет текущий tenant ID в генерацию ссылок внутри tenant-представлений.

Ключевой файл:

- [../app/Http/Middleware/SetTenantRouteParameter.php](../app/Http/Middleware/SetTenantRouteParameter.php)

## Платёжный сценарий

Логика подписок и платежей сосредоточена в:

- [../app/Http/Controllers/LandingController.php](../app/Http/Controllers/LandingController.php)
- [../app/Services/SubscriptionService.php](../app/Services/SubscriptionService.php)

В локальном режиме, если YooKassa credentials оставлены в demo-значении, активация подписки выполняется автоматически без реального платежа.

## Эксплуатационные заметки

- Tenant DB файлы относятся к окружению и не должны коммититься.
- Публичный лендинг не падает, если tenant-база отсутствует, а рендерится с пустой статистикой.
- Таблица `sessions` добавлена в tenant-миграции, потому что приложение сейчас использует `SESSION_DRIVER=database`.
