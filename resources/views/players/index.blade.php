<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Players Management
            </h2>
            <a href="{{ route('players.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="bi bi-person-plus-fill me-2"></i> Add New Player
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center">
                    <div class="icon icon-shape icon-lg bg-gradient-success text-white text-center shadow-success rounded-circle me-3 p-3">
                        <i class="bi bi-cash-coin fs-5"></i>
                    </div>
                    <div>
                        <h6 class="text-dark text-sm mb-0 text-uppercase font-weight-bolder">Total Monthly Salary</h6>
                        <h4 class="font-weight-bolder text-dark mb-0">{{ number_format($total_salary, 0) }} Ks</h4>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center">
                    <div class="icon icon-shape icon-lg bg-gradient-info text-white text-center shadow-info rounded-circle me-3 p-3">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="text-dark text-sm mb-0 text-uppercase font-weight-bolder">Total Players</h6>
                        <h4 class="font-weight-bolder text-dark mb-0">{{ $total_players }}</h4>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($players as $player)
                    <div class="group bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col overflow-hidden h-full relative">
                        <div class="absolute top-2 right-2 z-10 transition-opacity duration-300 flex gap-2">
                            <a href="{{ route('players.edit', $player) }}" class="btn btn-info icon-only mb-0 bg-blue-500 text-white p-2 rounded-full shadow-lg hover:bg-blue-600">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('players.destroy', $player) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this player?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger icon-only mb-0 bg-red-600 text-white p-2 rounded-full shadow-lg hover:bg-red-700">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="relative">
                            <img src="{{ $player->photo_url ?? asset('assets/img/default-player.png') }}" alt="Player Photo" class="h-96 w-full object-cover">
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent">
                                <h5 class="text-white text-lg font-bold truncate">
                                    {{ $player->ign }}
                                    @if($player->country_code)
                                        <img src="https://flagcdn.com/w40/{{ strtolower($player->country_code) }}.png" class="w-6 inline-block ml-2 rounded" alt="{{ $player->country_code }}">
                                    @endif
                                </h5>
                                <p class="text-gray-200 text-sm">{{ $player->real_name }}</p>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow justify-between">
                            <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                                <div><strong class="block text-xs text-gray-500 uppercase">Role</strong><span>{{ $player->role ?? 'N/A' }}</span></div>
                                <div><strong class="block text-xs text-gray-500 uppercase">Status</strong><span class="bg-gray-200 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $player->status ?? 'Active' }}</span></div>
                                <div><strong class="block text-xs text-gray-500 uppercase">Team</strong><span>{{ $player->team->name ?? 'Free Agent' }}</span></div>
                                <div><strong class="block text-xs text-gray-500 uppercase">Join Date</strong><span>{{ $player->join_date ? \Carbon\Carbon::parse($player->join_date)->format('M d, Y') : 'N/A' }}</span></div>
                                <div class="col-span-2"><strong class="block text-xs text-gray-500 uppercase">Salary</strong><span>{{ number_format($player->salary, 0) }} Ks</span></div>
                            </div>
                            
                            <div class="border-t pt-4 flex justify-center gap-6">
                                @if($player->facebook_url && $player->facebook_url !== '#')
                                    <a href="{{ $player->facebook_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xl"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if($player->youtube_url && $player->youtube_url !== '#')
                                    <a href="{{ $player->youtube_url }}" target="_blank" class="text-red-600 hover:text-red-800 text-xl"><i class="fab fa-youtube"></i></a>
                                @endif
                                @if($player->tiktok_url && $player->tiktok_url !== '#')
                                    <a href="{{ $player->tiktok_url }}" target="_blank" class="text-gray-800 hover:text-black text-xl"><i class="fab fa-tiktok"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
                        <i class="bi bi-info-circle me-2"></i> No players found. Click "Add New Player" to get started.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>