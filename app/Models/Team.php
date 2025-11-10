<?php
// app/Models/Team.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'logo_url',
        'description',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}