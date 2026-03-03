<nav class="bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 border-b border-slate-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- 標題與標誌 -->
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/30 text-white font-bold text-xl">
                    S
                </div>
                <div class="flex-shrink-0 font-extrabold text-xl tracking-tight text-white hidden sm:block">
                    Shield<span class="text-indigo-400">Pro</span>
                </div>
                
                <!-- 選單連結 (隱藏在小螢幕) -->
                <div class="hidden lg:block ml-8">
                    <div class="flex items-center space-x-1 bg-slate-800/50 p-1 rounded-2xl border border-slate-700/50">
                        <!-- 保全區塊 -->
                        <div class="flex items-center px-2">
                            <span class="text-[10px] text-slate-400 uppercase font-black tracking-widest mr-2">Guard</span>
                            <a href="{{ route('punch-in') }}" class="px-3 py-1.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentRoute == 'punch-in' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">打卡簽到</a>
                            <a href="{{ route('leave.index') }}" class="px-3 py-1.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentRoute == 'leave.index' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">假單申請</a>
                        </div>
                        
                        <div class="w-px h-6 bg-slate-700 mx-1"></div>

                        <!-- 主管區塊 -->
                        <div class="flex items-center px-2">
                            <span class="text-[10px] text-slate-400 uppercase font-black tracking-widest mr-2">Manager</span>
                            <a href="{{ route('manager.monitor') }}" class="px-3 py-1.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentRoute == 'manager.monitor' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">勤務監控</a>
                            <a href="{{ route('manager.leaves') }}" class="px-3 py-1.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentRoute == 'manager.leaves' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">假單審核</a>
                            <a href="{{ route('manager.scheduling') }}" class="px-3 py-1.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentRoute == 'manager.scheduling' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">智慧排班</a>
                        </div>

                        <div class="w-px h-6 bg-slate-700 mx-1"></div>
                        
                        <!-- 會計區塊 -->
                        <div class="flex items-center px-2">
                            <span class="text-[10px] text-slate-400 uppercase font-black tracking-widest mr-2">Finance</span>
                            <a href="{{ route('accountant.payroll') }}" class="px-3 py-1.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentRoute == 'accountant.payroll' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-700/50' }}">薪資結算</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 右側頭像區 (模擬) -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-emerald-400">系統運作中</span>
                </div>
                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 border-2 border-slate-700 flex items-center justify-center text-white font-bold text-xs shadow-inner">
                    A
                </div>
            </div>
        </div>
    </div>
    
    <!-- 行動裝置底端導覽 (Mobile Bottom Nav) -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 w-full bg-slate-900/95 backdrop-blur-lg border-t border-slate-800 pb-safe z-50 px-2 sm:px-6">
        <div class="flex justify-around py-3">
            <a href="{{ route('punch-in') }}" class="flex flex-col items-center gap-1 group w-16">
                <div class="p-2 rounded-xl transition-all duration-300 {{ $currentRoute == 'punch-in' ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40 text-white -translate-y-2' : 'text-slate-400 group-hover:bg-slate-800 group-hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <span class="text-[10px] font-medium {{ $currentRoute == 'punch-in' ? 'text-indigo-400' : 'text-slate-500' }}">打卡</span>
            </a>
            
            <a href="{{ route('manager.monitor') }}" class="flex flex-col items-center gap-1 group w-16">
                <div class="p-2 rounded-xl transition-all duration-300 {{ $currentRoute == 'manager.monitor' ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40 text-white -translate-y-2' : 'text-slate-400 group-hover:bg-slate-800 group-hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <span class="text-[10px] font-medium {{ $currentRoute == 'manager.monitor' ? 'text-indigo-400' : 'text-slate-500' }}">監控</span>
            </a>

            <a href="{{ route('manager.scheduling') }}" class="flex flex-col items-center gap-1 group w-16">
                <div class="p-2 rounded-xl transition-all duration-300 {{ $currentRoute == 'manager.scheduling' ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40 text-white -translate-y-2' : 'text-slate-400 group-hover:bg-slate-800 group-hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[10px] font-medium {{ $currentRoute == 'manager.scheduling' ? 'text-indigo-400' : 'text-slate-500' }}">排班</span>
            </a>

            <a href="{{ route('accountant.payroll') }}" class="flex flex-col items-center gap-1 group w-16">
                <div class="p-2 rounded-xl transition-all duration-300 {{ $currentRoute == 'accountant.payroll' ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40 text-white -translate-y-2' : 'text-slate-400 group-hover:bg-slate-800 group-hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-medium {{ $currentRoute == 'accountant.payroll' ? 'text-indigo-400' : 'text-slate-500' }}">薪資</span>
            </a>
            
            <a href="{{ route('leave.index') }}" class="flex flex-col items-center gap-1 group w-16">
                <div class="p-2 rounded-xl transition-all duration-300 {{ ($currentRoute == 'leave.index' || $currentRoute == 'manager.leaves') ? 'bg-indigo-500 shadow-lg shadow-indigo-500/40 text-white -translate-y-2' : 'text-slate-400 group-hover:bg-slate-800 group-hover:text-slate-200' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-[10px] font-medium {{ ($currentRoute == 'leave.index' || $currentRoute == 'manager.leaves') ? 'text-indigo-400' : 'text-slate-500' }}">假務</span>
            </a>
        </div>
    </div>
</nav>
