<?php

declare(strict_types=1);

use App\Models\BudgetItem;
use App\Models\Client;
use App\Models\ClientTimelineStep;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Task;
use App\Models\Tenant;
use App\Models\Vendor;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$profiles = [
    '906a4463-2114-4c3d-aa8d-d198c7727be9' => [
        'tenant' => [
            'name' => 'Ирина Вершинина',
            'email' => 'irina@newleader.demo',
            'landing_template' => 'editorial',
        ],
        'vendors' => [
            [
                'name' => 'Светлана Белова',
                'type' => 'Координатор',
                'email' => 'coord@demo.local',
                'phone' => '+7 915 220-10-10',
                'address' => 'Москва',
                'notes' => 'Координирует свадебные проекты и семейные торжества.',
                'is_active' => true,
            ],
            [
                'name' => 'White Sound',
                'type' => 'Звук и свет',
                'email' => 'sound@demo.local',
                'phone' => '+7 915 220-10-11',
                'address' => 'Москва',
                'notes' => 'Аренда звука, света и микрофонных комплектов.',
                'is_active' => true,
            ],
            [
                'name' => 'Loft Riverside',
                'type' => 'Площадка',
                'email' => 'loft@demo.local',
                'phone' => '+7 915 220-10-12',
                'address' => 'Москва, Бережковская набережная, 18',
                'notes' => 'Лофт с верандой у воды для свадеб и закрытых вечеров.',
                'is_active' => true,
            ],
        ],
        'clients' => [
            [
                'name' => 'Мария и Антон Смирновы',
                'email' => 'smirnovy@demo.local',
                'phone' => '+7 916 100-20-30',
                'notes' => 'Нужен интеллигентный свадебный сценарий без конкурсов с акцентом на историю пары.',
                'timeline' => [
                    'incoming_call' => ['completed_at' => '2026-04-05 11:00:00', 'notes' => 'Обсудили формат вечера и пожелания по стилю.'],
                    'meeting' => ['completed_at' => '2026-04-08 18:30:00', 'notes' => 'Провели бриф в Zoom и согласовали структуру программы.'],
                    'contract_signed' => ['completed_at' => '2026-04-12 14:00:00', 'notes' => 'Внесён аванс 50%.'],
                    'equipment_prep' => ['completed_at' => '2026-05-10 16:00:00', 'notes' => 'Подтвердили состав оборудования и схему подключения.'],
                    'event_prep' => ['completed_at' => '2026-05-18 12:00:00', 'notes' => 'Финальный созвон с площадкой и координатором.'],
                ],
                'event' => [
                    'title' => 'Свадьба Марии и Антона',
                    'type' => 'wedding',
                    'event_date' => '2026-05-23',
                    'event_time' => '16:00',
                    'venue_name' => 'Loft Riverside',
                    'venue_address' => 'Москва, Бережковская набережная, 18',
                    'expected_guests' => 65,
                    'budget_total' => 280000,
                    'status' => 'confirmed',
                    'description' => 'Камерная городская свадьба с живой музыкой, welcome-зоной и вечерним танцевальным блоком.',
                ],
                'guests' => [
                    ['name' => 'Екатерина Лаврова', 'email' => 'katya@example.com', 'phone' => '+7 916 700-11-01', 'category' => 'Семья', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-18 10:15:00', 'plus_one' => 1, 'notes' => 'Приедет к welcome.'],
                    ['name' => 'Дмитрий Фадеев', 'email' => 'fadeev@example.com', 'phone' => '+7 916 700-11-02', 'category' => 'Друзья', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-19 12:40:00', 'plus_one' => 0, 'notes' => 'Нужен безалкогольный стол.'],
                    ['name' => 'Ольга Платонова', 'email' => 'olga@example.com', 'phone' => '+7 916 700-11-03', 'category' => 'Коллеги', 'confirmed' => false, 'rsvp_status' => 'declined', 'responded_at' => '2026-04-20 09:20:00', 'plus_one' => 0, 'notes' => 'Будет в командировке.'],
                    ['name' => 'Сергей Волков', 'email' => 'sergey@example.com', 'phone' => '+7 916 700-11-04', 'category' => 'Друзья', 'confirmed' => false, 'rsvp_status' => null, 'responded_at' => null, 'plus_one' => 0, 'notes' => 'Ожидаем ответ.'],
                ],
                'tasks' => [
                    ['title' => 'Подтвердить тайминг церемонии', 'description' => 'Согласовать тайминг с координатором и фотографом.', 'due_date' => '2026-05-16', 'priority' => 'high', 'status' => 'in_progress', 'assigned_to' => 'Ирина', 'estimated_cost' => 0],
                    ['title' => 'Собрать плейлист финального блока', 'description' => 'Подобрать 12 треков для танцевальной части.', 'due_date' => '2026-05-17', 'priority' => 'medium', 'status' => 'pending', 'assigned_to' => 'DJ', 'estimated_cost' => 15000],
                    ['title' => 'Проверить сценарные карточки', 'description' => 'Распечатать карточки ведущего и координатора.', 'due_date' => '2026-05-21', 'priority' => 'medium', 'status' => 'pending', 'assigned_to' => 'Ассистент', 'estimated_cost' => 3000],
                ],
                'budget' => [
                    ['name' => 'Аренда площадки', 'estimated_amount' => 120000, 'actual_amount' => 120000, 'status' => 'paid', 'due_date' => '2026-05-10', 'vendor' => 'Loft Riverside', 'notes' => 'Оплачено полностью.'],
                    ['name' => 'Звук и свет', 'estimated_amount' => 58000, 'actual_amount' => 52000, 'status' => 'approved', 'due_date' => '2026-05-15', 'vendor' => 'White Sound', 'notes' => 'Подтверждён комплект на 60 гостей.'],
                    ['name' => 'Координация', 'estimated_amount' => 25000, 'actual_amount' => 25000, 'status' => 'paid', 'due_date' => '2026-05-01', 'vendor' => 'Светлана Белова', 'notes' => 'Аванс и финальный платёж проведены.'],
                ],
            ],
            [
                'name' => 'Елена Кузнецова',
                'email' => 'elena.k@demo.local',
                'phone' => '+7 916 100-20-31',
                'notes' => 'Запрос на юбилей в светлом классическом стиле с живой музыкой и поздравительным фильмом.',
                'timeline' => [
                    'incoming_call' => ['completed_at' => '2026-04-20 15:30:00', 'notes' => 'Первичный звонок, обсудили бюджет и программу.'],
                    'meeting' => ['completed_at' => '2026-04-22 19:00:00', 'notes' => 'Провели встречу, нужен мягкий интеллигентный юмор.'],
                ],
                'event' => [
                    'title' => 'Юбилей Елены Кузнецовой',
                    'type' => 'anniversary',
                    'event_date' => '2026-06-14',
                    'event_time' => '18:00',
                    'venue_name' => 'Ресторан «Сад на Яузе»',
                    'venue_address' => 'Москва, Подколокольный переулок, 12',
                    'expected_guests' => 50,
                    'budget_total' => 190000,
                    'status' => 'planning',
                    'description' => 'Семейный юбилей с живой музыкой, фильмом-поздравлением и интерактивами для гостей.',
                ],
                'guests' => [
                    ['name' => 'Наталья Кузнецова', 'email' => 'natasha@example.com', 'phone' => '+7 916 700-12-01', 'category' => 'Семья', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-22 13:00:00', 'plus_one' => 1, 'notes' => 'Поможет со сбором поздравлений.'],
                    ['name' => 'Владимир Орехов', 'email' => 'orehov@example.com', 'phone' => '+7 916 700-12-02', 'category' => 'Друзья', 'confirmed' => false, 'rsvp_status' => null, 'responded_at' => null, 'plus_one' => 0, 'notes' => 'Пока без ответа.'],
                ],
                'tasks' => [
                    ['title' => 'Подготовить коммерческое предложение', 'description' => 'Собрать три варианта программы и смету.', 'due_date' => '2026-04-25', 'priority' => 'high', 'status' => 'in_progress', 'assigned_to' => 'Ирина', 'estimated_cost' => 0],
                    ['title' => 'Запросить референсы по музыке', 'description' => 'Получить любимые песни именинницы.', 'due_date' => '2026-04-26', 'priority' => 'medium', 'status' => 'pending', 'assigned_to' => 'Менеджер', 'estimated_cost' => 0],
                ],
                'budget' => [
                    ['name' => 'Предварительная аренда зала', 'estimated_amount' => 90000, 'actual_amount' => 0, 'status' => 'draft', 'due_date' => '2026-05-05', 'vendor' => null, 'notes' => 'Ожидаем подтверждение площадки.'],
                ],
            ],
            [
                'name' => 'Технопарк «Север»',
                'email' => 'events@northpark.demo',
                'phone' => '+7 916 100-20-32',
                'notes' => 'Нужен ведущий на летний корпоратив и церемонию награждения.',
                'timeline' => [
                    'incoming_call' => ['completed_at' => '2026-03-12 10:00:00', 'notes' => 'Обсудили формат и состав гостей.'],
                    'meeting' => ['completed_at' => '2026-03-15 12:00:00', 'notes' => 'Утвердили шоу-блок и награждение.'],
                    'contract_signed' => ['completed_at' => '2026-03-18 16:00:00', 'notes' => 'Договор подписан, постоплата пять дней.'],
                    'equipment_prep' => ['completed_at' => '2026-04-01 17:00:00', 'notes' => 'Утверждена схема сцены и экранов.'],
                    'event_prep' => ['completed_at' => '2026-04-10 11:00:00', 'notes' => 'Финальная редакция сценария согласована.'],
                    'event_day' => ['completed_at' => '2026-04-18 21:30:00', 'notes' => 'Мероприятие прошло успешно.'],
                    'follow_up' => ['completed_at' => '2026-04-19 13:00:00', 'notes' => 'Получили отзыв и фотоотчёт.'],
                ],
                'event' => [
                    'title' => 'Летний корпоратив Технопарка «Север»',
                    'type' => 'corporate',
                    'event_date' => '2026-04-18',
                    'event_time' => '19:00',
                    'venue_name' => 'Речной клуб «Орбита»',
                    'venue_address' => 'Москва, Ленинградское шоссе, 39',
                    'expected_guests' => 120,
                    'budget_total' => 420000,
                    'status' => 'completed',
                    'description' => 'Корпоратив для команды технопарка с награждением, шоу-программой и DJ-сетом.',
                ],
                'guests' => [
                    ['name' => 'Анна Горина', 'email' => 'anna.g@example.com', 'phone' => '+7 916 700-13-01', 'category' => 'HR', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-05 15:40:00', 'plus_one' => 0, 'notes' => 'Контакт по рассадке.'],
                    ['name' => 'Павел Дронов', 'email' => 'pavel.d@example.com', 'phone' => '+7 916 700-13-02', 'category' => 'Руководство', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-06 09:10:00', 'plus_one' => 0, 'notes' => 'Выступление семь минут.'],
                ],
                'tasks' => [
                    ['title' => 'Подготовить итоговый отчёт', 'description' => 'Собрать фото, тайминг и отзыв клиента.', 'due_date' => '2026-04-20', 'priority' => 'low', 'status' => 'completed', 'assigned_to' => 'Ирина', 'estimated_cost' => 0],
                ],
                'budget' => [
                    ['name' => 'Ведение и режиссура', 'estimated_amount' => 180000, 'actual_amount' => 180000, 'status' => 'paid', 'due_date' => '2026-04-19', 'vendor' => null, 'notes' => 'Гонорар закрыт по акту.'],
                    ['name' => 'Техническое обеспечение', 'estimated_amount' => 110000, 'actual_amount' => 108000, 'status' => 'paid', 'due_date' => '2026-04-18', 'vendor' => 'White Sound', 'notes' => 'Финальная сумма чуть ниже сметы.'],
                ],
            ],
        ],
    ],
    '96786bbd-3a80-4f1f-95c0-c39947c15b46' => [
        'tenant' => [
            'name' => 'Алексей Орлов',
            'email' => 'alexey@newleader.demo',
            'landing_template' => 'neon',
        ],
        'vendors' => [
            [
                'name' => 'Stage Vision',
                'type' => 'Экран и графика',
                'email' => 'stage@demo.local',
                'phone' => '+7 926 330-20-10',
                'address' => 'Санкт-Петербург',
                'notes' => 'LED-экраны, сценическая графика и таймкод.',
                'is_active' => true,
            ],
            [
                'name' => 'Арт-группа «Пульс»',
                'type' => 'Шоу-программа',
                'email' => 'pulse@demo.local',
                'phone' => '+7 926 330-20-11',
                'address' => 'Санкт-Петербург',
                'notes' => 'Танцевальный блок, welcome-перформанс и интерактивы.',
                'is_active' => true,
            ],
            [
                'name' => 'Hall 1896',
                'type' => 'Площадка',
                'email' => 'hall1896@demo.local',
                'phone' => '+7 926 330-20-12',
                'address' => 'Санкт-Петербург, набережная Обводного канала, 118',
                'notes' => 'Индустриальная площадка для премий и конференций.',
                'is_active' => true,
            ],
        ],
        'clients' => [
            [
                'name' => 'Группа компаний «Сфера»',
                'email' => 'pr@sfera.demo',
                'phone' => '+7 921 300-40-50',
                'notes' => 'Ежегодная премия для партнёров и сотрудников компании.',
                'timeline' => [
                    'incoming_call' => ['completed_at' => '2026-04-02 10:30:00', 'notes' => 'Бриф от PR-директора.'],
                    'meeting' => ['completed_at' => '2026-04-04 14:00:00', 'notes' => 'Очная встреча с оргкомитетом.'],
                    'contract_signed' => ['completed_at' => '2026-04-07 11:00:00', 'notes' => 'Подписали договор и утвердили гонорар.'],
                    'equipment_prep' => ['completed_at' => '2026-04-20 16:00:00', 'notes' => 'Согласован контент экрана и технический райдер.'],
                ],
                'event' => [
                    'title' => 'Премия «Сфера. Люди года»',
                    'type' => 'corporate',
                    'event_date' => '2026-05-29',
                    'event_time' => '19:30',
                    'venue_name' => 'Hall 1896',
                    'venue_address' => 'Санкт-Петербург, набережная Обводного канала, 118',
                    'expected_guests' => 180,
                    'budget_total' => 560000,
                    'status' => 'confirmed',
                    'description' => 'Премия для сотрудников и партнёров с церемонией награждения, экранным контентом и afterparty.',
                ],
                'guests' => [
                    ['name' => 'Дарья Мальцева', 'email' => 'daria@example.com', 'phone' => '+7 921 700-21-01', 'category' => 'Оргкомитет', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-15 13:00:00', 'plus_one' => 0, 'notes' => 'Контакт по VIP-рассадке.'],
                    ['name' => 'Игорь Руденко', 'email' => 'igor@example.com', 'phone' => '+7 921 700-21-02', 'category' => 'Партнёры', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-17 18:25:00', 'plus_one' => 1, 'notes' => 'Будет с супругой.'],
                    ['name' => 'Марина Светлова', 'email' => 'marina@example.com', 'phone' => '+7 921 700-21-03', 'category' => 'Пресса', 'confirmed' => false, 'rsvp_status' => 'declined', 'responded_at' => '2026-04-18 09:45:00', 'plus_one' => 0, 'notes' => 'Не успевает на рейс.'],
                ],
                'tasks' => [
                    ['title' => 'Утвердить сценарий награждения', 'description' => 'Подготовить тексты под 12 номинаций.', 'due_date' => '2026-05-10', 'priority' => 'high', 'status' => 'in_progress', 'assigned_to' => 'Алексей', 'estimated_cost' => 0],
                    ['title' => 'Собрать титры и графику', 'description' => 'Получить логотипы партнёров и собрать пакеты экранов.', 'due_date' => '2026-05-14', 'priority' => 'medium', 'status' => 'pending', 'assigned_to' => 'Stage Vision', 'estimated_cost' => 42000],
                ],
                'budget' => [
                    ['name' => 'Сценическая графика', 'estimated_amount' => 90000, 'actual_amount' => 85000, 'status' => 'approved', 'due_date' => '2026-05-12', 'vendor' => 'Stage Vision', 'notes' => 'Включая 12 пакетов номинаций.'],
                    ['name' => 'Шоу-программа', 'estimated_amount' => 70000, 'actual_amount' => 0, 'status' => 'draft', 'due_date' => '2026-05-18', 'vendor' => 'Арт-группа «Пульс»', 'notes' => 'На согласовании два выхода.'],
                    ['name' => 'Аренда площадки', 'estimated_amount' => 210000, 'actual_amount' => 210000, 'status' => 'paid', 'due_date' => '2026-05-01', 'vendor' => 'Hall 1896', 'notes' => 'Внесён депозит.'],
                ],
            ],
            [
                'name' => 'Анна Новикова',
                'email' => 'anna.n@demo.local',
                'phone' => '+7 921 300-40-51',
                'notes' => 'Частный день рождения в формате коктейльной вечеринки на крыше.',
                'timeline' => [
                    'incoming_call' => ['completed_at' => '2026-04-21 17:10:00', 'notes' => 'Нужен современный ведущий и DJ.'],
                ],
                'event' => [
                    'title' => 'День рождения Анны Новиковой',
                    'type' => 'birthday',
                    'event_date' => '2026-06-06',
                    'event_time' => '20:00',
                    'venue_name' => 'Roof Bar «Парус»',
                    'venue_address' => 'Санкт-Петербург, Петровская коса, 9',
                    'expected_guests' => 35,
                    'budget_total' => 145000,
                    'status' => 'planning',
                    'description' => 'Вечеринка на крыше с барным шоу, DJ-сетом и лёгкой интерактивной программой.',
                ],
                'guests' => [
                    ['name' => 'Виктор Зайцев', 'email' => 'v.z@example.com', 'phone' => '+7 921 700-22-01', 'category' => 'Друзья', 'confirmed' => false, 'rsvp_status' => null, 'responded_at' => null, 'plus_one' => 0, 'notes' => 'Ожидаем ответ после рассылки.'],
                ],
                'tasks' => [
                    ['title' => 'Подготовить две концепции вечеринки', 'description' => 'Сделать варианты по музыке и интерактивам.', 'due_date' => '2026-04-26', 'priority' => 'high', 'status' => 'pending', 'assigned_to' => 'Алексей', 'estimated_cost' => 0],
                ],
                'budget' => [
                    ['name' => 'Черновая смета по площадке', 'estimated_amount' => 65000, 'actual_amount' => 0, 'status' => 'draft', 'due_date' => '2026-04-28', 'vendor' => null, 'notes' => 'Ждём ответ от площадки по депозиту.'],
                ],
            ],
            [
                'name' => 'Лицей № 12',
                'email' => 'grad@lyceum12.demo',
                'phone' => '+7 921 300-40-52',
                'notes' => 'Выпускной для 11 классов с торжественной частью и afterparty.',
                'timeline' => [
                    'incoming_call' => ['completed_at' => '2026-02-10 09:00:00', 'notes' => 'Запрос от родительского комитета.'],
                    'meeting' => ['completed_at' => '2026-02-14 18:00:00', 'notes' => 'Согласовали формат, продолжительность и смету.'],
                    'contract_signed' => ['completed_at' => '2026-02-18 12:00:00', 'notes' => 'Подписан договор с родительским комитетом.'],
                    'equipment_prep' => ['completed_at' => '2026-03-25 15:00:00', 'notes' => 'Подтвердили сцену и фото-зону.'],
                    'event_prep' => ['completed_at' => '2026-04-12 11:30:00', 'notes' => 'Согласовали выходы выпускников и сценарий награждения.'],
                ],
                'event' => [
                    'title' => 'Выпускной Лицея № 12',
                    'type' => 'graduation',
                    'event_date' => '2026-06-25',
                    'event_time' => '18:30',
                    'venue_name' => 'Конгресс-холл «Нева»',
                    'venue_address' => 'Санкт-Петербург, Московский проспект, 97',
                    'expected_guests' => 220,
                    'budget_total' => 610000,
                    'status' => 'confirmed',
                    'description' => 'Большой выпускной вечер с церемонией, танцевальным блоком, фото-зоной и DJ-afterparty.',
                ],
                'guests' => [
                    ['name' => 'Оксана Белова', 'email' => 'oksana@example.com', 'phone' => '+7 921 700-23-01', 'category' => 'Родительский комитет', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-10 14:00:00', 'plus_one' => 0, 'notes' => 'Координатор от родителей.'],
                    ['name' => 'Илья Коротков', 'email' => 'ilya@example.com', 'phone' => '+7 921 700-23-02', 'category' => 'Выпускники', 'confirmed' => true, 'rsvp_status' => 'confirmed', 'responded_at' => '2026-04-11 19:30:00', 'plus_one' => 0, 'notes' => 'Отвечает за видео-вставку класса.'],
                ],
                'tasks' => [
                    ['title' => 'Собрать список номеров от классов', 'description' => 'Получить финальный список выступлений и роликов.', 'due_date' => '2026-05-20', 'priority' => 'high', 'status' => 'in_progress', 'assigned_to' => 'Алексей', 'estimated_cost' => 0],
                    ['title' => 'Подготовить механику afterparty', 'description' => 'Согласовать DJ-блок и световые эффекты.', 'due_date' => '2026-05-25', 'priority' => 'medium', 'status' => 'pending', 'assigned_to' => 'Арт-группа «Пульс»', 'estimated_cost' => 30000],
                ],
                'budget' => [
                    ['name' => 'Аренда конгресс-холла', 'estimated_amount' => 260000, 'actual_amount' => 260000, 'status' => 'paid', 'due_date' => '2026-04-15', 'vendor' => null, 'notes' => 'Депозит оплачен.'],
                    ['name' => 'Танцевальный блок', 'estimated_amount' => 80000, 'actual_amount' => 0, 'status' => 'approved', 'due_date' => '2026-06-10', 'vendor' => 'Арт-группа «Пульс»', 'notes' => 'Два выхода и интерактив с залом.'],
                ],
            ],
        ],
    ],
];

foreach ($profiles as $tenantId => $profile) {
    $tenant = Tenant::findOrFail($tenantId);
    $tenant->name = $profile['tenant']['name'];
    $tenant->email = $profile['tenant']['email'];
    $tenant->landing_template = $profile['tenant']['landing_template'];
    $tenant->save();

    tenancy()->initialize($tenant);

    DB::transaction(function () use ($profile): void {
        ClientTimelineStep::query()->delete();
        BudgetItem::query()->delete();
        Task::query()->delete();
        Guest::query()->delete();
        Event::query()->delete();
        Client::query()->delete();
        Vendor::query()->delete();

        $vendors = [];

        foreach ($profile['vendors'] as $vendorData) {
            $vendor = Vendor::create($vendorData);
            $vendors[$vendor->name] = $vendor;
        }

        foreach ($profile['clients'] as $clientData) {
            $eventData = $clientData['event'];
            $guestRows = $clientData['guests'];
            $taskRows = $clientData['tasks'];
            $budgetRows = $clientData['budget'];
            $timelineRows = $clientData['timeline'];

            $client = Client::create([
                'name' => $clientData['name'],
                'type' => 'lead',
                'pipeline_stage' => 'incoming_call',
                'contract_signed_at' => null,
                'email' => $clientData['email'],
                'phone' => $clientData['phone'],
                'notes' => $clientData['notes'],
            ]);

            $client->ensureTimelineSteps();

            foreach ($client->timelineSteps as $step) {
                if (! isset($timelineRows[$step->code])) {
                    continue;
                }

                $step->update([
                    'completed_at' => Carbon::parse($timelineRows[$step->code]['completed_at']),
                    'notes' => $timelineRows[$step->code]['notes'] ?? null,
                ]);
            }

            $client->refreshPipelineState();

            $event = $client->events()->create($eventData);

            foreach ($guestRows as $guestRow) {
                $event->guests()->create($guestRow);
            }

            foreach ($taskRows as $taskRow) {
                $event->tasks()->create($taskRow);
            }

            foreach ($budgetRows as $budgetRow) {
                $vendorName = $budgetRow['vendor'];
                unset($budgetRow['vendor']);

                $budgetRow['vendor_id'] = $vendorName && isset($vendors[$vendorName])
                    ? $vendors[$vendorName]->id
                    : null;

                $event->budgetItems()->create($budgetRow);
            }
        }
    });

    tenancy()->end();

    fwrite(STDOUT, 'OK ' . $tenantId . ' ' . $profile['tenant']['name'] . PHP_EOL);
}
