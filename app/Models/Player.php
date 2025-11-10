<?php
// app/Models/Player.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'ign', 'real_name', 'role', 'status', 'photo_url', 'team_id',
        'country_code', 'join_date', 'salary', 'bio',
        'facebook_url', 'youtube_url', 'tiktok_url',
    ];

    // Player တစ်ယောက်က Team တစ်ခုမှာ ရှိတယ်
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}