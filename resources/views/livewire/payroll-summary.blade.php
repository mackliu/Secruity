<div class="max-w-7xl mx-auto space-y-6">
    <!-- 標題區塊與操作列 -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-6 sm:p-8 rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2.5 bg-emerald-100 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">薪資結算中心</h1>
            </div>
            <p class="text-slate-500 font-medium ml-14">根據實際考勤與排班狀況，自動結算全體保全人員薪資</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 ml-14 md:ml-0 bg-slate-50 p-2 rounded-2xl border border-slate-100">
            <div class="flex items-center space-x-2 bg-white rounded-xl shadow-sm border border-slate-200 p-1 px-2">
                <select wire:model="year" class="pl-3 pr-8 py-2 border-none bg-transparent focus:ring-0 text-sm font-bold text-slate-700 cursor-pointer">
                    <option value="2025">2025 年</option>
                    <option value="2026">2026 年</option>
                </select>
                <div class="w-px h-6 bg-slate-200"></div>
                <select wire:model="month" class="pl-3 pr-8 py-2 border-none bg-transparent focus:ring-0 text-sm font-bold text-slate-700 cursor-pointer">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}">{{ sprintf('%02d', $m) }} 月</option>
                    @endfor
                </select>
            </div>
            
            <button wire:click="calculateAll" class="flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 font-bold shadow-md shadow-slate-800/20 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                重新計算
            </button>
            <button wire:click="exportExcel" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-bold shadow-md shadow-emerald-600/30 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                匯出 Excel
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-bold flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- 數據表格 -->
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-5 text-left text-xs font-black text-slate-500 uppercase tracking-wider">員工姓名 (工號)</th>
                        <th class="px-6 py-5 text-center text-xs font-black text-slate-500 uppercase tracking-wider">完成班次</th>
                        <th class="px-6 py-5 text-center text-xs font-black text-slate-500 uppercase tracking-wider">總計工時</th>
                        <th class="px-6 py-5 text-center text-xs font-black text-slate-500 uppercase tracking-wider">異常次數</th>
                        <th class="px-6 py-5 text-right text-xs font-black text-slate-500 uppercase tracking-wider">基本薪資</th>
                        <th class="px-6 py-5 text-right text-xs font-black text-slate-500 uppercase tracking-wider bg-slate-100 rounded-tl-xl">應發總金額</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payrollData as $row)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300 flex items-center justify-center text-slate-700 font-black text-sm mr-4 shadow-sm">
                                    {{ mb_substr($row['name'], 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-base font-bold text-slate-900">{{ $row['name'] }}</div>
                                    <div class="text-xs font-medium text-slate-500 mt-0.5">{{ $row['employee_id'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-700 font-bold text-sm">
                                {{ $row['total_shifts'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-lg font-black text-indigo-600 font-mono">{{ $row['total_hours'] }}</span>
                            <span class="text-xs text-slate-500 font-bold ml-1">hr</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            @if($row['abnormal_count'] > 0)
                                <span class="px-3 py-1.5 rounded-lg text-sm font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                    {{ $row['abnormal_count'] }} 次
                                </span>
                            @else
                                <span class="text-slate-400 font-bold text-sm">無異常</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-right font-mono text-slate-600 font-medium">
                            ${{ number_format($row['basic_salary']) }}
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-right bg-slate-50 group-hover:bg-slate-100 transition-colors">
                            <span class="text-xl font-black text-emerald-600 font-mono">
                                ${{ number_format($row['net_pay']) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="text-slate-500 font-bold">目前月份尚無薪資數據</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs font-medium text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                結算公式僅計入狀態為『已完成』之排班紀錄。
            </div>
        </div>
    </div>
</div>
