<?php
// app/Models/Scrim.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrim extends Model
{
    use HasFactory;

    protected $fillable = [
        'scrim_name',
        'fee',
        'rank',
        'prize_pool',
        'match_time',
    ];
    
    protected $casts = [
        'match_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ScrimDetail::class); 
    }
}