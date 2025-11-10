<?php
// app/Http/Controllers/PublicController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Team;
use App\Models\Sponsor; // <-- (၁) Sponsor Model ကို use လုပ်ပါ

class PublicController extends Controller
{
    /**
     * Homepage (Team တွေရော Sponsor တွေပါ ဆွဲထုတ်မယ်)
     */
    public function home()
    {
        $teams = Team::orderBy('name')->get();
        
        // === (၁) Sponsor တွေကို ဆွဲထုတ်ပါ ===
        $sponsors = Sponsor::where('is_active', true)
                           ->orderBy('sort_order', 'asc')
                           ->get();
                           
        // === (၂) Sponsor တွေကို "Level" အလိုက် အုပ်စုခွဲပါ ===
        // $groupedSponsors['Title Partner'] -> (Title Partner တွေ)
        // $groupedSponsors['Official Partner'] -> (Official Partner တွေ)
        $groupedSponsors = $sponsors->groupBy('level');
        
        return view('public.home', [
            'teams' => $teams,
            'groupedSponsors' => $groupedSponsors, // (၃) အုပ်စုခွဲထားတဲ့ Data ကို ပို့ပါ
        ]);
    }

    /**
     * Roster Page (Player တွေရော Management တွေပါ ပေါင်းပြီး ဆွဲထုတ်မယ်)
     */
    public function showRoster(Request $request)
    {
        // === (၅) Team ID ကို ယူပါ (မပါလာရင် default team 1) ===
        $teamId = $request->input('team', 1); 
        $team = Team::find($teamId); // <-- (၆) Team object ကို ရှာပါ

        // Team မရှိရင် Homepage ကို ပြန်လွှဲပါ
        if (!$team) {
            return redirect()->route('public.home');
        }

        // === (၇) Status တွေကို အစဉ်လိုက် သတ်မှတ်ပါ ===
        $statusOrder = "
            CASE 
                WHEN status = 'Player' THEN 1
                WHEN status = 'Substitute' THEN 2
                WHEN status = 'Coach' THEN 3
                WHEN status = 'TM' THEN 4
                WHEN status = 'GM' THEN 5
                ELSE 6 
            END
        ";
        $activeStatuses = ['Player', 'Substitute', 'Coach', 'TM', 'GM'];

        // === (၈) Query တစ်ခုတည်းနဲ့ အားလုံးကို ဆွဲထုတ်ပါ ===
        $allMembers = Player::with('team')
                        ->where('team_id', $teamId) // Team ID နဲ့ filter လုပ်ပါ
                        ->whereIn('status', $activeStatuses)
                        ->orderByRaw($statusOrder)
                        ->orderBy('ign')
                        ->get();
        
        // === (၉) Data အားလုံးကို View ဆီ ပို့ပါ ===
        return view('public.roster', [
            'allMembers' => $allMembers,
            'team' => $team, // Team object ကို ပို့မယ်
            'pageTitle' => $team->name . " ROSTER",   // Title ကို Team name အလိုက် ပြောင်းမယ်
            'gameLogo' => $team->logo_url ?? asset('img/aod_logo.png'), // Team logo ကို ပို့မယ်
        ]);
    }

    /**
     * Player တစ်ယောက်တည်းရဲ့ Profile Page ကို ပြသမယ်
     */
    public function showPlayerProfile(Player $player)
    {
        // (ဒါက အရင်အတိုင်း မှန်ကန်နေပါတယ်)
        return view('public.player-profile', [
            'player' => $player
        ]);
    }
}