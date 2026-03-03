<div class="max-w-7xl mx-auto space-y-6">
    <!-- 標題區塊 -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800">智慧排班管理中心</h1>
            </div>
            <p class="text-sm text-slate-500 font-medium ml-11">系統自動檢查請假衝突與重複排班</p>
        </div>
    </div>

    <!-- 排班操作區 -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
        <!-- 裝飾背景 -->
        <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-purple-100 to-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

        <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
            <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
            新增單日排班
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-5 items-end relative z-10">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">選擇保全</label>
                <select wire:model="selectedGuard" class="w-full pl-4 pr-10 py-3 bg-slate-50 border-slate-200 focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-inner font-medium text-slate-700">
                    @foreach($guards as $guard)
                        <option value="{{ $guard->id }}">{{ $guard->name }} ({{ $guard->employee_id }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">選擇站點</label>
                <select wire:model="selectedSite" class="w-full pl-4 pr-10 py-3 bg-slate-50 border-slate-200 focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-inner font-medium text-slate-700">
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">日期</label>
                <input type="date" wire:model="date" class="w-full px-4 py-3 bg-slate-50 border-slate-200 focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-inner font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">時間 (起 ~ 迄)</label>
                <div class="flex items-center space-x-2">
                    <input type="time" wire:model="start_time" class="px-3 py-3 bg-slate-50 border-slate-200 focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-inner font-medium text-slate-700 w-full text-center">
                    <span class="text-slate-400 font-bold">-</span>
                    <input type="time" wire:model="end_time" class="px-3 py-3 bg-slate-50 border-slate-200 focus:ring-purple-500 focus:border-purple-500 rounded-xl shadow-inner font-medium text-slate-700 w-full text-center">
                </div>
            </div>
            <div>
                <button wire:click="saveShift" class="w-full flex justify-center items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-4 rounded-xl font-bold shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all duration-300 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    確定排班
                </button>
            </div>
        </div>

        @if($conflictMessage)
            <div class="mt-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-bold flex items-center gap-3 animate-pulse">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ $conflictMessage }}
            </div>
        @endif

        @if($statusMessage)
            <div class="mt-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $statusMessage }}
            </div>
        @endif
    </div>

    <!-- 班表列表區 -->
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span>
                未來班表預覽
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-wider">日期</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-wider">保全人員</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-wider">執勤站點</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-wider">時段</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-wider">狀態</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentShifts as $shift)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                {{ $shift->date->format('Y/m/d') }} <span class="text-slate-400 text-xs ml-1">({{ $shift->date->isoFormat('ddd') }})</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 border border-blue-200 flex items-center justify-center text-blue-700 font-bold text-xs mr-3">
                                        {{ mb_substr($shift->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-bold text-slate-900">{{ $shift->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $shift->site->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono font-medium">
                                {{ substr($shift->scheduled_start, 0, 5) }} - {{ substr($shift->scheduled_end, 0, 5) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                    已排定
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium bg-slate-50/50">
                                目前尚未安排任何未來班表
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
