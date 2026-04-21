# Multi-Tenant SaaS Laravel Application with YooKassa

Мультитенантное SaaS-приложение с оплатой подписки через ЮKassa. Интерфейс выполнен на **AdminLTE 3**.

## Особенности

- **Лендинг с тарифами** — регистрация через оплату подписки
- **Автоматическое создание тенанта** после успешной оплаты
- **Изолированные БД** для каждого тенанта (stancl/tenancy)
- **Интеграция с ЮKassa** для приёма платежей
- **Админ-панель** на AdminLTE 3

## Структура

- **Центральная часть** (`localhost`, `127.0.0.1`):
  - Лендинг с тарифами
  - Оформление подписки и оплата
  - Админ-панель управления тенантами

- **Tenant-часть** (на поддомене тенанта):
  - Панель управления магазином
  - Товары, заказы, платежи

## Установка

1. Установите зависимости:
   ```bash
   composer install
   ```

2. Настройте `.env`:
   ```
   APP_URL=http://localhost:8000
   DB_CONNECTION=sqlite

   YOOKASSA_SHOP_ID=ваш_shop_id
   YOOKASSA_SECRET_KEY=ваш_secret_key
   ```

3. Запустите миграции и сидеры:
   ```bash
   php artisan migrate
   php artisan db:seed --class=SubscriptionPlanSeeder
   ```

4. Запустите сервер:
   ```bash
   php artisan serve
   ```

## Поток регистрации

1. Пользователь заходит на `http://localhost:8000` (лендинг с тарифами)
2. Выбирает тариф → переходит на страницу оформления
3. Заполняет имя, email, желаемый домен (например `myshop`)
4. Оплачивает подписку через ЮKassa
5. После успешной оплаты:
   - Автоматически создаётся тенант с БД
   - Запускаются миграции в БД тенанта
   - Пользователь перенаправляется на страницу успеха

## Настройка доменов

Для локальной разработки добавьте в `hosts` (`C:\Windows\System32\drivers\etc\hosts`):
```
127.0.0.1    myshop.localhost
```

После регистрации тенанта `myshop` он будет доступен по адресу:
`http://myshop.localhost:8000`

## Настройка ЮKassa

1. Получите `shopId` и `secretKey` в личном кабинете ЮKassa
2. Укажите их в `.env`
3. Настройте webhook в кабинете ЮKassa:
   ```
   http://localhost:8000/webhooks/yookassa
   ```

## Архитектура

### Модели (центральная БД)
- `CentralSubscriptionPlan` — тарифные планы
- `Subscription` — подписки пользователей
- `CentralPayment` — платежи подпискок
- `Tenant` (stancl/tenancy) — тенанты

### Модели (tenant БД)
- `Product` — товары
- `Order` — заказы
- `Payment` — платежи заказов
- `SubscriptionPlan` — локальные тарифы (опционально)

### Сервисы
- `YooKassaService` — оплата заказов внутри тенанта
- `SubscriptionService` — оплата подписок, создание тенантов

## Команды

```bash
# Запуск миграций для всех тенантов
php artisan tenants:migrate

# Сидирование всех тенантов
php artisan tenants:seed

# Просмотр всех тенантов
php artisan tenants:list
```

## Страницы

| URL | Описание |
|-----|----------|
| `GET /` | Лендинг с тарифами |
| `GET /landing/checkout/{plan}` | Оформление подписки |
| `POST /landing/subscribe` | Создание подписки и перенаправление на оплату |
| `GET /landing/subscribe/callback/{subscription}` | Callback после оплаты |
| `GET /admin/tenants` | Список всех тенантов |
| `http://{tenant}.localhost/` | Панель управления тенанта |
