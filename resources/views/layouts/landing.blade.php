<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SaaS Платформа')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('landing.index') }}" class="text-xl font-bold text-gray-800">SaaS Platform</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('landing.index') }}" class="text-gray-600 hover:text-gray-900">Тарифы</a>
                    <a href="{{ route('admin.tenants.index') }}" class="text-gray-600 hover:text-gray-900">Админ</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-100 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} SaaS Platform. Все права защищены.
        </div>
    </footer>
</body>
</html>
