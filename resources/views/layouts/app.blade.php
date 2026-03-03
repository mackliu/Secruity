<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'ShieldPro 保全管理系統' }}</title>
        
        <!-- 字體 -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700;900&display=swap" rel="stylesheet">
        
        <!-- 使用 Laravel Vite 載入本地編譯的資產 -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
    </head>
    <body class="h-full flex flex-col text-slate-800 antialiased selection:bg-indigo-500 selection:text-white pb-24 md:pb-0">
        <!-- 導覽列 -->
        @livewire('navbar')

        <!-- 主內容區 -->
        <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 transition-all duration-300">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- 頁尾 -->
        <footer class="bg-white border-t border-slate-200 mt-auto hidden md:block">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} ShieldPro Security Management. All rights reserved.
                </p>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
