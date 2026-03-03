<div class="p-6 bg-white rounded-xl shadow-lg border border-gray-100">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">假單核准中心</h1>
        <p class="text-sm text-gray-500">處理所有保全人員的請假申請</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($pendingRequests as $req)
            <div class="p-5 border rounded-xl hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-gray-900">{{ $req->user->name }}</span>
                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-gray-600">
                                {{ $req->type == 'personal' ? '事假' : ($req->type == 'sick' ? '病假' : '特休') }}
                            </span>
                        </div>
                        <p class="text-sm text-blue-600 mt-1">
                            {{ $req->start_time->format('Y/m/d H:i') }} ~ {{ $req->end_time->format('Y/m/d H:i') }}
                        </p>
                        <p class="text-sm text-gray-700 mt-2 bg-gray-50 p-2 rounded">
                            理由: {{ $req->reason }}
                        </p>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <button 
                            wire:click="approve({{ $req->id }})" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold"
                        >
                            核准
                        </button>
                        
                        <div class="flex space-x-1">
                            <input 
                                type="text" 
                                wire:model="rejectReason.{{ $req->id }}" 
                                placeholder="駁回原因" 
                                class="text-xs p-2 border rounded w-32"
                            >
                            <button 
                                wire:click="reject({{ $req->id }})" 
                                class="px-2 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs"
                            >
                                駁回
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-400 italic">目前沒有待處理的假單</div>
        @endforelse
    </div>
</div>
