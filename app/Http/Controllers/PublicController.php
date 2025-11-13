<?php
// app/Http/Controllers/PublicController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Team;
use App\Models\Sponsor; 

class PublicController extends Controller
{

    public function home()
    {
        $teams = Team::orderBy('name')->get();

        $sponsors = Sponsor::where('is_active', true)
                           ->orderBy('sort_order', 'asc')
                           ->get();

        $groupedSponsors = $sponsors->groupBy('level');
        
        return view('public.home', [
            'teams' => $teams,
            'groupedSponsors' => $groupedSponsors,
        ]);
    }


    public function showRoster(Request $request)
    {
        $teamId = $request->input('team', 1); 
        $team = Team::find($teamId);

        if (!$team) {
            return redirect()->route('public.home');
        }

        $activeStatuses = ['Player', 'Substitute', 'Coach', 'TM', 'GM'];

        $allMembersQuery = Player::with('team')
                        ->where('team_id', $teamId)
                        ->whereIn('status', $activeStatuses)
                        ->orderBy('ign')
                        ->get();
        
        $statusSortOrder = [
            'Player' => 1,
            'Substitute' => 2,
            'Coach' => 3,
            'TM' => 4,
            'GM' => 5,
        ];

        $allMembers = $allMembersQuery->sortBy(function ($member) use ($statusSortOrder) {
            return $statusSortOrder[$member->status] ?? 99;
        });
        
        return view('public.roster', [
            'allMembers' => $allMembers,
            'team' => $team, 
            'pageTitle' => $team->name . " ROSTER",   
            'gameLogo' => $team->logo_url ?? asset('img/aod_logo.png'), 
        ]);
    }

    /**
     * Player Profile Page
     */
    public function showPlayerProfile(Player $player)
    {
        
        return view('public.player-profile', [
            'player' => $player
        ]);
    }
}