<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <section class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                                <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider">စုစုပေါင်း ဝင်ငွေ</h2>
                                <p class="mt-1 text-3xl font-bold text-green-600">
                                    {{ number_format($totalIncome, 1) }} MMK
                                </p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                                <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider">စုစုပေါင်း သုံးစွဲငွေ</h2>
                                <p class="mt-1 text-3xl font-bold text-red-600">
                                    {{ number_format($totalExpense, 1) }} MMK
                                </p>
                            </div>
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                                <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider">လက်ကျန်ငွေ</h2>
                                <p class="mt-1 text-3xl font-bold text-blue-600">
                                    {{ number_format($balance, 1) }} MMK
                                </p>
                            </div>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">အသစ် ထည့်သွင်းရန်</h3>
                            
                            <form action="{{ route('budget.store') }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">အမျိုးအစား</label>
                                    <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="income">ဝင်ငွေ</option>
                                        <option value="expense">သုံးစွဲငွေ</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="text" class="block text-sm font-medium text-gray-700">အကြောင်းအရာ (ဥပမာ: မနက်စာ)</label>
                                    <input type="text" id="text" name="text" placeholder="အကြောင်းအရာ..." required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">ငွေပမာဏ (MMK)</label>
                                    <input type="number" id="amount" name="amount" placeholder="ပမာဏ..." step="0.01" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                
                                <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    ထည့်သွင်းမည်
                                </button>

                                @if ($errors->any())
                                    <div class_name="text-red-600 text-sm mt-2">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">မှတ်တမ်းများ</h3>

                            @if (session('success'))
                                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <ul class="divide-y divide-gray-200">
                                @forelse ($transactions as $transaction)
                                    <li class="py-4 flex justify-between items-center {{ $transaction->type === 'income' ? 'border-l-4 border-green-500 pl-3' : 'border-l-4 border-red-500 pl-3' }}">
                                        <div>
                                            <span class="text-gray-800 font-medium">{{ $transaction->text }}</span>
                                            <span class="block text-sm text-gray-500">{{ $transaction->created_at->format('d M Y') }}</span> </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <span class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                                {{ number_format($transaction->amount, 1) }}
                                            </span>
                                            
                                            <form action="{{ route('budget.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('ဒီမှတ်တမ်းကို တကယ်ဖျက်မှာလား?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 text-sm font-medium">ဖျက်မည်</button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-4 text-gray-500">မှတ်တမ်းများ မရှိသေးပါ။</li>
                                @endforelse
                            </ul>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>