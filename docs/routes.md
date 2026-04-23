# Маршруты

## Центральные маршруты

Описаны в [../routes/web.php](../routes/web.php).

### Маркетинг и биллинг

- `GET /` — главный SaaS-лендинг
- `GET /landing/checkout/{plan}` — форма оформления тарифа
- `POST /landing/subscribe` — создание подписки
- `GET /landing/subscribe/callback/{subscription}` — страница после оплаты
- `POST /webhooks/yookassa` — webhook YooKassa

### Публичный лендинг ведущего

- `GET /hosts/{tenant}` — публичная промо-страница ведущего

### Админка

- `GET /admin/tenants` — список tenant-ов
- `GET /admin/tenants/create` — форма создания tenant-а
- `POST /admin/tenants` — сохранение tenant-а
- `GET /admin/tenants/{tenant}` — карточка tenant-а
- `PATCH /admin/tenants/{tenant}/landing` — смена шаблона лендинга
- `DELETE /admin/tenants/{tenant}` — удаление tenant-а

- `GET /admin/subscriptions` — список подписок
- `GET /admin/subscriptions/{subscription}` — карточка подписки
- `POST /admin/subscriptions/{subscription}/mark-as-paid` — ручная активация
- `POST /admin/subscriptions/{subscription}/cancel` — ручная отмена

## Tenant-маршруты

Описаны в [../routes/tenant.php](../routes/tenant.php).

Базовый префикс:

`/tenant/{tenant}`

### Дашборд

- `GET /tenant/{tenant}` — tenant dashboard

### Мероприятия

- resource routes для `events`

### Клиенты

- resource routes для `clients`

### Подрядчики

- resource routes для `vendors`

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

## Рекомендуемые URL для демо

- `/`
- `/admin/tenants`
- `/tenant/96786bbd-3a80-4f1f-95c0-c39947c15b46`
- `/hosts/96786bbd-3a80-4f1f-95c0-c39947c15b46`
