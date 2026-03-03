@extends('layouts.app')

@section('content')
    <div class="relative bg-white overflow-hidden rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 mb-12">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-10 px-6 sm:px-8 lg:px-12">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold mb-4 border border-indigo-100">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-500 mr-2"></span>
                            系統 v1.0 正式上線
                        </div>
                        <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">新一代的企業級</span>
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mt-2">保全管理平台</span>
                        </h1>
                        <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            從 GPS 智能打卡、自動化排班衝突檢查，到一鍵薪資結算。ShieldPro 提供您最完整、最安全的保全人力管理解決方案。
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                            <div class="rounded-xl shadow-lg shadow-indigo-200">
                                <a href="{{ route('punch-in') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg transition-transform active:scale-95">
                                    保全簽到端
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0">
                                <a href="{{ route('manager.monitor') }}" class="w-full flex items-center justify-center px-8 py-3 border border-slate-200 text-base font-medium rounded-xl text-indigo-700 bg-white hover:bg-slate-50 md:py-4 md:text-lg transition-transform active:scale-95">
                                    進入主管後台
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-slate-50 flex items-center justify-center p-8">
            <!-- 靜態功能展示區 -->
            <div class="relative w-full max-w-lg">
                <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-100 p-8 grid grid-cols-2 gap-6">
                    <div class="bg-indigo-50 rounded-2xl p-6 flex flex-col items-center justify-center gap-3 border border-indigo-100 shadow-sm">
                        <div class="p-3 bg-indigo-500 text-white rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg></div>
                        <span class="text-sm font-bold text-slate-700">精準定位</span>
                    </div>
                    <div class="bg-purple-50 rounded-2xl p-6 flex flex-col items-center justify-center gap-3 border border-purple-100 shadow-sm">
                        <div class="p-3 bg-purple-500 text-white rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                        <span class="text-sm font-bold text-slate-700">智慧排班</span>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-6 flex flex-col items-center justify-center gap-3 border border-emerald-100 shadow-sm">
                        <div class="p-3 bg-emerald-500 text-white rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-sm font-bold text-slate-700">LINE 核准</span>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-6 flex flex-col items-center justify-center gap-3 border border-blue-100 shadow-sm">
                        <div class="p-3 bg-blue-500 text-white rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-sm font-bold text-slate-700">自動結算</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 快速入口區塊 -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <a href="{{ route('punch-in') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">保全手機端</h3>
            <p class="text-sm text-slate-500">掃描 QR Code 與 GPS 地理圍欄防弊打卡，線上請假不求人。</p>
        </a>

        <a href="{{ route('manager.monitor') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">主管控制台</h3>
            <p class="text-sm text-slate-500">即時監控全區崗位狀態，智慧排班自動避免請假衝突。</p>
        </a>

        <a href="{{ route('accountant.payroll') }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">財務報表</h3>
            <p class="text-sm text-slate-500">一鍵結算全公司月度薪資，自動計算工時與扣款，並匯出 Excel。</p>
        </a>
    </div>
@endsection
