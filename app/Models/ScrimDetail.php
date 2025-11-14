<?php
// app/Models/ScrimDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrimDetail extends Model
{
    use HasFactory;
    
    // Table နာမည်ကို အတိအကျ ပြောပြပါ
    protected $table = 'scrim_details';

    protected $fillable = [
        'scrim_id',
        'player_id',
        'Map',
        'Kill',
        'Assists',
        'Damage',
        'Heals',
        'Survival_Time',
        'Desc',
    ];

    // Scrim နှင့် Player တွေနဲ့ ချိတ်ဆက်ပါ
    public function scrim() { return $this->belongsTo(Scrim::class); }
    public function player() { return $this->belongsTo(Player::class); }
}