<div class="max-w-md mx-auto relative pt-4">
    <!-- 頂部裝飾背景 -->
    <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-indigo-600 to-indigo-800 rounded-b-[2.5rem] -z-10 shadow-lg shadow-indigo-900/20"></div>

    <div class="px-4">
        <!-- 標頭資訊 -->
        <div class="text-center pt-6 pb-8 text-white">
            <h2 class="text-3xl font-extrabold tracking-tight">勤務簽到</h2>
            <p class="text-indigo-200 mt-1 text-sm font-medium">GPS 智能定位打卡系統</p>
        </div>

        <!-- 主卡片 -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl shadow-slate-200/50 p-6 sm:p-8 border border-white">
            
            <div class="space-y-6">
                <!-- 站點選擇 -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        目前所在站點 (崗位)
                    </label>
                    <div class="relative">
                        <select wire:model="selectedSite" class="block w-full pl-4 pr-10 py-3.5 text-base border-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-2xl bg-slate-50 appearance-none shadow-inner font-medium text-slate-800">
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}">{{ $site->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- 狀態訊息 -->
                @if($statusMessage)
                    <div class="rounded-2xl p-4 flex items-start gap-3 {{ $isError ? 'bg-red-50 border border-red-100' : 'bg-emerald-50 border border-emerald-100' }}">
                        @if($isError)
                            <div class="text-red-500 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="text-sm font-semibold text-red-800">{{ $statusMessage }}</div>
                        @else
                            <div class="text-emerald-500 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-sm font-semibold text-emerald-800">{{ $statusMessage }}</div>
                        @endif
                    </div>
                @endif

                <!-- 打卡按鈕區 -->
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <button 
                        type="button"
                        onclick="getLocation('in')"
                        class="relative group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-[2rem] shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-all duration-300 active:scale-95 overflow-hidden"
                    >
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:animate-shine"></div>
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        <span class="text-lg font-bold">簽到上班</span>
                    </button>
                    
                    <button 
                        type="button"
                        onclick="getLocation('out')"
                        class="relative group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-slate-700 to-slate-800 text-white rounded-[2rem] shadow-xl shadow-slate-800/30 hover:shadow-slate-800/50 transition-all duration-300 active:scale-95 overflow-hidden"
                    >
                        <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:animate-shine"></div>
                        <svg class="w-8 h-8 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="text-lg font-bold">簽退下班</span>
                    </button>
                </div>
            </div>

            <!-- GPS 資訊與備援方案 -->
            <div class="mt-8 pt-6 border-t border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-slate-500">GPS 定位系統</span>
                    </div>
                    <div class="text-[10px] font-mono text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100" id="gps-display">
                        -- . ------ , -- . ------
                    </div>
                </div>

                <!-- 備援按鈕 (隱藏或小按鈕形式) -->
                <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold text-amber-800">GPS 定位失敗？</span>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="punch('in', true)" class="flex-1 py-2 bg-white border border-amber-200 text-amber-700 text-xs font-bold rounded-xl shadow-sm hover:bg-amber-100 transition duration-200">
                            強制簽到 (手動)
                        </button>
                        <button wire:click="punch('out', true)" class="flex-1 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl shadow-sm hover:bg-slate-100 transition duration-200">
                            強制簽退 (手動)
                        </button>
                    </div>
                    <p class="text-[10px] text-amber-600 mt-2 text-center">* 手動簽到將自動通知主管並標記為異常，供事後核對。</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 加入閃爍動畫的 CSS -->
    <style>
        @keyframes shine {
            100% { transform: skewX(-12deg) translateX(200%); }
        }
        .animate-shine {
            animation: shine 1.5s ease-in-out infinite;
        }
    </style>

    <script>
        function getLocation(type) {
            // 變更按鈕狀態，避免重複點擊
            const display = document.getElementById('gps-display');
            display.innerText = "定位中...";
            display.classList.add('animate-pulse', 'text-indigo-500');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        display.innerText = lat.toFixed(6) + ', ' + lon.toFixed(6);
                        display.classList.remove('animate-pulse', 'text-indigo-500');
                        
                        // 調用 Livewire 方法
                        @this.setLocation(lat, lon).then(() => {
                            @this.punch(type);
                        });
                    },
                    (error) => {
                        alert("無法獲取位置: " + error.message);
                        display.innerText = "定位失敗";
                        display.classList.remove('animate-pulse', 'text-indigo-500');
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                alert("瀏覽器不支持定位功能");
            }
        }
    </script>
</div>
