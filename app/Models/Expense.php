<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'title', 'decs', 'amount', 'transaction_date'];
    
    // ဒီ Expense က User တစ်ယောက်ကို ပိုင်ဆိုင်တယ်
    public function user() { return $this->belongsTo(User::class); }
}