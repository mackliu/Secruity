<nav class="bg-blue-600 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="text-xl font-bold tracking-wider">ShieldPro</a>
            </div>

            @auth
            <!-- Menu Items -->
            <div class="hidden md:flex space-x-4">
                @if(auth()->user()->role === 'security')
                    <a href="{{ route('punch-in') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 {{ request()->routeIs('punch-in') ? 'bg-blue-800' : '' }}">上班打卡</a>
                    <a href="{{ route('leave.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 {{ request()->routeIs('leave.index') ? 'bg-blue-800' : '' }}">請假申請</a>
                @endif

                @if(auth()->user()->role === 'manager' || auth()->user()->role === 'admin')
                    <a href="{{ route('manager.monitor') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 {{ request()->routeIs('manager.monitor') ? 'bg-blue-800' : '' }}">考勤監控</a>
                    <a href="{{ route('manager.leaves') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 {{ request()->routeIs('manager.leaves') ? 'bg-blue-800' : '' }}">假單審核</a>
                    <a href="{{ route('manager.scheduling') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 {{ request()->routeIs('manager.scheduling') ? 'bg-blue-800' : '' }}">智慧排班</a>
                @endif

                @if(auth()->user()->role === 'accountant' || auth()->user()->role === 'admin')
                    <a href="{{ route('accountant.payroll') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 {{ request()->routeIs('accountant.payroll') ? 'bg-blue-800' : '' }}">薪資結算</a>
                @endif
            </div>

            <!-- User Info & Logout -->
            <div class="flex items-center space-x-4">
                <div class="text-right mr-2">
                    <div class="text-sm font-bold">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-blue-200">{{ strtoupper(auth()->user()->role) }} ({{ auth()->user()->employee_id }})</div>
                </div>
                <button wire:click="logout" class="bg-blue-800 hover:bg-red-600 p-2 rounded-full transition-colors duration-200" title="登出系統">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </div>
            @endauth
        </div>
    </div>
</nav>
