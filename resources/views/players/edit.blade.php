<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('players.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Players</a> / Edit {{ $player->ign }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <form method="POST" action="{{ route('players.update', $player) }}" class="space-y-6">
                        @csrf
                        @method('PATCH') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ign" class="block text-sm font-medium text-gray-700">IGN (In-Game Name) *</label>
                                <input type="text" name="ign" id="ign" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required value="{{ old('ign', $player->ign) }}">
                            </div>
                            <div>
                                <label for="real_name" class="block text-sm font-medium text-gray-700">Real Name</label>
                                <input type="text" name="real_name" id="real_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('real_name', $player->real_name) }}">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <input type="text" name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('role', $player->role) }}">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach ($player_statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', $player->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="photo_url" class="block text-sm font-medium text-gray-700">Photo URL</label>
                                <input type="url" name="photo_url" id="photo_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="https://..." value="{{ old('photo_url', $player->photo_url) }}">
                            </div>
                            
                            <div>
                                <label for="team_id" class="block text-sm font-medium text-gray-700">Team</label>
                                <select name="team_id" id="team_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">No Team (Free Agent)</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}" {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="country_code" class="block text-sm font-medium text-gray-700">Country Code</label>
                                <input type="text" name="country_code" id="country_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g., MM" value="{{ old('country_code', $player->country_code) }}">
                            </div>
                            <div>
                                <label for="join_date" class="block text-sm font-medium text-gray-700">Join Date</label>
                                <input type="date" name="join_date" id="join_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('join_date', $player->join_date) }}">
                            </div>
                            <div>
                                <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                                <input type="number" name="salary" id="salary" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="0" step="1000" value="{{ old('salary', $player->salary) }}">
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea name="bio" id="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $player->bio) }}</textarea>
                            </div>
                            
                            <hr class="col-span-1 md:col-span-2 my-2">
                            
                            <div class="col-span-1 md:col-span-2"><label class="block text-sm font-medium text-gray-500">Social Media Links</label></div>
                            <div><input type="url" name="facebook_url" placeholder="Facebook URL" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('facebook_url', $player->facebook_url) }}"></div>
                            <div><input type="url" name="youtube_url" placeholder="YouTube URL" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('youtube_url', $player->youtube_url) }}"></div>
                            <div><input type="url" name="tiktok_url" placeholder="TikTok URL" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('tiktok_url', $player->tiktok_url) }}"></div>
                        </div>

                        <div class="flex justify-end pt-6">
                            <a href="{{ route('players.index') }}" class="text-gray-600 py-2 px-4 rounded-md me-2">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update Player
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>