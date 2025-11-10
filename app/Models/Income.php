<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'amount', 'description', 'transaction_date'];
    
    // ဒီ Income က User တစ်ယောက်ကို ပိုင်ဆိုင်တယ်
    public function user() { return $this->belongsTo(User::class); }
}