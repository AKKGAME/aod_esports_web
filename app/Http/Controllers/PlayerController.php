<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Player တွေ အားလုံးကို ပြသမယ် (index page)
     */
    public function index()
    {
        // Legacy code: SELECT p.*, t.name AS team_name ...
        $players = Player::with('team')  // Team relationship ကို တစ်ခါတည်း ယူခဲ့မယ်
                         ->orderBy('id', 'desc')
                         ->get();

        // Legacy code: SELECT SUM(salary) ...
        $total_salary = Player::sum('salary');

        // Legacy code: count($players)
        $total_players = $players->count();
        
        $player_statuses = ['Player', 'Substitute', 'Inactive', 'Coach', 'TM', 'GM'];

        return view('players.index', compact(
            'players', 
            'total_salary', 
            'total_players',
            'player_statuses' // (ဒါကို View Composer နဲ့ လုပ်တာ ပိုကောင်းပေမယ့်၊ လောလောဆယ် ဒီလို သုံးပါမယ်)
        ));
    }

    /**
     * Player အသစ် ထည့်မယ့် form ကို ပြသမယ်
     */
    public function create()
    {
        $teams = Team::orderBy('name')->get();
        $player_statuses = ['Player', 'Substitute', 'Inactive', 'Coach', 'TM', 'GM'];
        
        return view('players.create', compact('teams', 'player_statuses'));
    }

    /**
     * Player အသစ်ကို Database ထဲ သိမ်းမယ်
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ign' => 'required|string|max:255',
            'real_name' => 'nullable|string',
            'team_id' => 'nullable|exists:teams,id',
            'salary' => 'nullable|numeric|min:0',
            'photo_url' => 'nullable|url',
            'role' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|max:5',
            'join_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            // ===========================================
        ]);

        Player::create($validatedData);

        return redirect()->route('players.index')->with('success', 'Player created successfully.');
    }

    /**
     * Player ပြင်မယ့် form ကို ပြသမယ်
     */
    public function edit(Player $player) // Route Model Binding
    {
        $teams = Team::orderBy('name')->get();
        $player_statuses = ['Player', 'Substitute', 'Inactive', 'Coach', 'TM', 'GM'];
        
        return view('players.edit', compact('player', 'teams', 'player_statuses'));
    }

    /**
     * Player ကို Database ထဲမှာ Update လုပ်မယ်
     */

    public function update(Request $request, Player $player) // Route Model Binding
    {
        $validatedData = $request->validate([
            'ign' => 'required|string|max:255',
            'real_name' => 'nullable|string',
            'team_id' => 'nullable|exists:teams,id',
            'salary' => 'nullable|numeric|min:0',
            'photo_url' => 'nullable|url',
            'role' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|max:5',
            'join_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            // ===========================================
        ]);
        
        $player->update($validatedData);

        return redirect()->route('players.index')->with('success', 'Player updated successfully.');
    }

    /**
     * Player ကို ဖျက်မယ်
     */
    public function destroy(Player $player) // Route Model Binding
    {
        // Legacy code: $_SESSION['role'] === 'super_admin'
        // ဒီနေရာမှာ Authorization (Gate/Policy) သုံးရပါမယ်။
        // လောလောဆယ် Auth user တိုင်းကို ဖျက်ခွင့်ပြုထားပါမယ်။
        
        $player->delete();

        return redirect()->route('players.index')->with('success', 'Player deleted successfully.');
    }
}