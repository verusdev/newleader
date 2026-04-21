<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use App\Models\Product;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Базовый',
            'price' => 990,
            'interval' => 'month',
            'description' => 'Базовый тариф для небольших магазинов',
            'features' => json_encode(['До 100 товаров', 'Базовая аналитика', 'Email поддержка']),
            'is_active' => true,
        ]);

        SubscriptionPlan::create([
            'name' => 'Профессиональный',
            'price' => 2990,
            'interval' => 'month',
            'description' => 'Расширенный тариф для растущего бизнеса',
            'features' => json_encode(['Безлимитные товары', 'Расширенная аналитика', 'Приоритетная поддержка', 'API доступ']),
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Пример товара',
            'description' => 'Это демонстрационный товар',
            'price' => 1500,
            'is_active' => true,
        ]);
    }
}
