# Маршруты

## Central маршруты

Описаны в [../routes/web.php](../routes/web.php).

### Маркетинг и подписка

- `GET /` — главный SaaS-лендинг
- `GET /landing/checkout/{plan}` — форма выбора тарифа
- `POST /landing/subscribe` — создание подписки
- `GET /landing/subscribe/callback/{subscription}` — callback после оплаты
- `POST /webhooks/yookassa` — webhook YooKassa

### Публичные страницы

- `GET /hosts/{tenant}` — рекламный лендинг ведущего
- `GET /invite/{tenant}/{eventToken}` — invitation landing мероприятия
- `GET /invite/{tenant}/{eventToken}/{guestToken}` — персональное приглашение гостя
- `POST /invite/{tenant}/{eventToken}/rsvp/{guestToken?}` — отправка RSVP

### Админка tenant-ов

- `GET /admin/tenants` — список tenant-ов
- `GET /admin/tenants/create` — форма создания tenant-а
- `POST /admin/tenants` — сохранение tenant-а
- `GET /admin/tenants/{tenant}` — карточка tenant-а
- `PATCH /admin/tenants/{tenant}/landing` — смена шаблона host landing
- `DELETE /admin/tenants/{tenant}` — удаление tenant-а

### Админка подписок

- `GET /admin/subscriptions` — список подписок
- `GET /admin/subscriptions/{subscription}` — карточка подписки
- `POST /admin/subscriptions/{subscription}/mark-as-paid` — ручная активация
- `POST /admin/subscriptions/{subscription}/cancel` — ручная отмена

## Tenant маршруты

Описаны в [../routes/tenant.php](../routes/tenant.php).

Базовый префикс:

`/tenant/{tenant}`

### Дашборд

- `GET /tenant/{tenant}` — tenant dashboard

### Клиенты и лиды

- resource routes для `clients`
- `POST /tenant/{tenant}/clients/{client}/timeline/{step}/toggle` — переключение этапа таймлайна

### Мероприятия

- resource routes для `events`
- `GET /tenant/{tenant}/events-calendar` — календарь мероприятий
- `GET /tenant/{tenant}/events-calendar/feed` — JSON feed для календаря

### Гости внутри мероприятия

- `GET /tenant/{tenant}/events/{event}/guests`
- `POST /tenant/{tenant}/events/{event}/guests`
- `GET /tenant/{tenant}/events/{event}/guests/create`
- `GET /tenant/{tenant}/events/{event}/guests/{guest}/edit`
- `PUT/PATCH /tenant/{tenant}/events/{event}/guests/{guest}`
- `DELETE /tenant/{tenant}/events/{event}/guests/{guest}`
- `POST /tenant/{tenant}/events/{event}/guests/{guest}/toggle`

### Задачи внутри мероприятия

- `GET /tenant/{tenant}/events/{event}/tasks`
- `POST /tenant/{tenant}/events/{event}/tasks`
- `GET /tenant/{tenant}/events/{event}/tasks/create`
- `GET /tenant/{tenant}/events/{event}/tasks/{task}/edit`
- `PUT/PATCH /tenant/{tenant}/events/{event}/tasks/{task}`
- `DELETE /tenant/{tenant}/events/{event}/tasks/{task}`
- `POST /tenant/{tenant}/events/{event}/tasks/{task}/toggle`

### Бюджет внутри мероприятия

- `GET /tenant/{tenant}/events/{event}/budget`
- `POST /tenant/{tenant}/events/{event}/budget`
- `GET /tenant/{tenant}/events/{event}/budget/create`
- `GET /tenant/{tenant}/events/{event}/budget/{budgetItem}/edit`
- `PUT/PATCH /tenant/{tenant}/events/{event}/budget/{budgetItem}`
- `DELETE /tenant/{tenant}/events/{event}/budget/{budgetItem}`

### Подрядчики

- resource routes для `vendors`

## Рекомендуемые URL для demo

- `/`
- `/admin/tenants`
- `/tenant/906a4463-2114-4c3d-aa8d-d198c7727be9`
- `/hosts/906a4463-2114-4c3d-aa8d-d198c7727be9`
- `/tenant/96786bbd-3a80-4f1f-95c0-c39947c15b46`
- `/hosts/96786bbd-3a80-4f1f-95c0-c39947c15b46`

Для invitation demo:

- карточка мероприятия в CRM
- общий invitation URL из карточки события
- персональный invitation URL из списка гостей
