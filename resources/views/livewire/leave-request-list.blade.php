<div class="p-4 max-w-lg mx-auto bg-white rounded-xl shadow-md space-y-6">
    <div class="text-center border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">請假申請系統</h2>
        <p class="text-gray-500">保全人員專用頁面</p>
    </div>

    <!-- 申請區 -->
    <form wire:submit.prevent="submitRequest" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">假別</label>
                <select wire:model="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="personal">事假</option>
                    <option value="sick">病假</option>
                    <option value="annual">特休</option>
                    <option value="special">公假/特別假</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">狀態</label>
                <div class="mt-2 text-sm text-blue-600 font-semibold italic">準備申請中...</div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">開始時間</label>
                <input type="datetime-local" wire:model="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">結束時間</label>
                <input type="datetime-local" wire:model="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">事由 (請簡述)</label>
            <textarea wire:model="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="請輸入請假原因..."></textarea>
            @error('reason') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        @if($statusMessage)
            <div class="p-3 text-sm bg-green-100 text-green-700 rounded-lg">
                {{ $statusMessage }}
            </div>
        @endif

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 active:scale-95 transition">
            提交假單申請
        </button>
    </form>

    <!-- 列表區 -->
    <div class="mt-10">
        <h3 class="text-lg font-bold text-gray-700 mb-4 border-l-4 border-blue-500 pl-2">近期請假紀錄</h3>
        <div class="space-y-3">
            @forelse($myRequests as $req)
                <div class="p-4 rounded-lg border {{ $req->status == 'approved' ? 'bg-green-50 border-green-200' : ($req->status == 'rejected' ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200') }}">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold text-blue-700">
                            {{ $req->type == 'personal' ? '事假' : ($req->type == 'sick' ? '病假' : ($req->type == 'annual' ? '特休' : '特別假')) }}
                        </span>
                        <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $req->status == 'approved' ? 'bg-green-200 text-green-800' : ($req->status == 'rejected' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                            {{ $req->status == 'approved' ? '已核准' : ($req->status == 'rejected' ? '駁回' : '審核中') }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $req->start_time->format('m/d H:i') }} 至 {{ $req->end_time->format('m/d H:i') }}
                    </p>
                    <p class="text-sm mt-1 text-gray-700">{{ $req->reason }}</p>
                    @if($req->reject_reason)
                        <p class="text-xs text-red-600 mt-2"><strong>駁回原因:</strong> {{ $req->reject_reason }}</p>
                    @endif
                </div>
            @empty
                <div class="text-center text-gray-400 py-4 italic">尚無請假紀錄</div>
            @endforelse
        </div>
    </div>
</div>
