<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div>
            <div class="flex justify-center">
                <span class="text-3xl font-bold text-blue-600 tracking-wider">ShieldPro</span>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                登入系統
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                請輸入您的員工編號進行驗證
            </p>
        </div>
        <form class="mt-8 space-y-6" wire:submit.prevent="login">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="employee_id" class="sr-only">員工編號</label>
                    <input id="employee_id" wire:model="employee_id" type="text" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                        placeholder="員工編號 (例如: S001)">
                </div>
                <div>
                    <label for="password" class="sr-only">密碼</label>
                    <input id="password" wire:model="password" type="password" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                        placeholder="密碼">
                </div>
            </div>

            @error('employee_id')
                <div class="text-red-500 text-sm mt-1 text-center font-medium">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-400 group-hover:text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    登入
                </button>
            </div>
            
            <div class="text-center text-xs text-gray-400 mt-4">
                忘記密碼請洽總部人力資源組
            </div>
        </form>
    </div>

    <!-- LIFF SDK & Initialization -->
    <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const liffId = "{{ config('line.liff_id') }}";
            
            if (liffId) {
                liff.init({ liffId }).then(() => {
                    if (liff.isLoggedIn()) {
                        const profile = liff.getProfile();
                        profile.then(p => {
                            @this.call('loginViaLine', p.userId);
                        });
                    }
                }).catch(err => {
                    console.error('LIFF Init error', err);
                });
            }
        });
    </script>
</div>
