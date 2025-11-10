<aside class="w-64 bg-gray-800 text-white min-h-screen hidden md:block">
    <div class="p-4">
        <a href="{{ route('budget.index') }}" class="flex items-center space-x-2 text-white text-xl font-bold mb-5">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-200" />
            <span>My Admin</span>
        </a>
        
        <nav class="space-y-2">
            
            <a href="{{ route('budget.index') }}" 
               class="flex items-center space-x-2 py-2 px-3 rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('budget.*') ? 'bg-gray-900 text-white' : '' }}">
                <i class="bi bi-wallet2 w-5 text-center"></i> <span>ဘတ်ဂျက်</span>
            </a>
            
            <a href="{{ route('players.index') }}" 
               class="flex items-center space-x-2 py-2 px-3 rounded-md text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('players.*') ? 'bg-gray-900 text-white' : '' }}">
                <i class="bi bi-people-fill w-5 text-center"></i> <span>Players</span>
            </a>

            </nav>
    </div>
</aside>