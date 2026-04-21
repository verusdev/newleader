<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CentralSubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        CentralSubscriptionPlan::create([
            'name' => 'Старт',
            'price' => 990,
            'interval' => 'month',
            'description' => 'Для небольших магазинов',
            'features' => json_encode(['До 100 товаров', 'Базовая аналитика', 'Email поддержка', 'Приём платежей ЮKassa']),
            'is_active' => true,
        ]);

        CentralSubscriptionPlan::create([
            'name' => 'Бизнес',
            'price' => 2990,
            'interval' => 'month',
            'description' => 'Для растущего бизнеса',
            'features' => json_encode(['Безлимитные товары', 'Расширенная аналитика', 'Приоритетная поддержка', 'API доступ', 'Мультиязычность']),
            'is_active' => true,
        ]);

        CentralSubscriptionPlan::create([
            'name' => 'Корпорация',
            'price' => 9990,
            'interval' => 'month',
            'description' => 'Для крупного бизнеса',
            'features' => json_encode(['Всё из Бизнес +', 'Персональный менеджер', 'SLA 99.9%', 'Кастомная разработка', 'Выделенный сервер']),
            'is_active' => true,
        ]);
    }
}
