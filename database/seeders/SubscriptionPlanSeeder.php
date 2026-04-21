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
            'description' => 'Для начинающих организаторов',
            'features' => json_encode(['До 3 мероприятий', 'Базовое управление задачами', 'Список гостей до 50', 'Email поддержка']),
            'is_active' => true,
        ]);

        CentralSubscriptionPlan::create([
            'name' => 'Профи',
            'price' => 2990,
            'interval' => 'month',
            'description' => 'Для профессиональных организаторов',
            'features' => json_encode(['Безлимитные мероприятия', 'Полный функционал CRM', 'Безлимитные гости', 'Управление бюджетом', 'База подрядчиков', 'Приоритетная поддержка']),
            'is_active' => true,
        ]);

        CentralSubscriptionPlan::create([
            'name' => 'Агентство',
            'price' => 7990,
            'interval' => 'month',
            'description' => 'Для команд и агентств',
            'features' => json_encode(['Всё из Профи +', 'Мультипользовательский доступ', 'API интеграции', 'Белая этикетка', 'Персональный менеджер', 'SLA 99.9%']),
            'is_active' => true,
        ]);
    }
}
