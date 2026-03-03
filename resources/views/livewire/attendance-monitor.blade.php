<div wire:poll.10s class="max-w-7xl mx-auto">
    <!-- 標題區塊 -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800">勤務即時監控看板</h1>
            </div>
            <p class="text-sm text-slate-500 font-medium ml-11">系統每 10 秒自動從資料庫刷新最新考勤數據</p>
        </div>
        <div class="flex space-x-3 items-center bg-slate-50 p-2 rounded-xl border border-slate-100">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                正常打卡
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-rose-100 text-rose-700">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                異常 (超出圍欄)
            </span>
        </div>
    </div>

    <!-- 數據表格 -->
    <div class="bg-white shadow-xl shadow-slate-200/40 rounded-2xl overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">打卡時間</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">保全姓名</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">站點 (崗位)</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-black text-slate-500 uppercase tracking-wider">類型</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-black text-slate-500 uppercase tracking-wider">偏移距離</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-wider">系統判定狀態</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse($attendances as $attendance)
                    <tr class="transition-colors hover:bg-slate-50/50 {{ $attendance->is_abnormal ? 'bg-rose-50/30' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono">
                            {{ $attendance->check_time->format('m/d H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                    {{ mb_substr($attendance->user->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-bold text-slate-900">{{ $attendance->user->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                            {{ $attendance->shift?->site?->name ?? '臨時指派/未知' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($attendance->type == 'in')
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">簽到</span>
                            @else
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">簽退</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono font-medium {{ $attendance->is_abnormal ? 'text-rose-600' : 'text-slate-500' }}">
                            {{ $attendance->distance }} m
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($attendance->is_abnormal)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-rose-100 text-rose-700 border border-rose-200 shadow-sm">
                                異常: {{ $attendance->remark }}
                            </span>
                            @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm">
                                正常
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium bg-slate-50/50">
                            目前尚無任何打卡紀錄
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 分頁 -->
    <div class="mt-6">
        {{ $attendances->links() }}
    </div>
</div>
