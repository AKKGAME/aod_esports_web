<?php

use Illuminate\Support\Facades\Route;

// === (၁) အသုံးပြုမယ့် Controller တွေ အားလုံးကို အပေါ်ဆုံးမှာ တစ်စုတည်း ကြေညာပါ ===
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BudgetController; 
use App\Http\Controllers\PublicController;
// PlayerController ကို မသုံးတော့ပါ (Filament က သူ့အလုပ်ကို /admin မှာ လုပ်သွားပါပြီ)


/*
|--------------------------------------------------------------------------
| Public Website Routes (Login မလိုသူ၊ ပရိသတ် ကြည့်ရန်)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/roster', [PublicController::class, 'showRoster'])->name('public.roster');


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Login ဝင်ပြီးမှ သုံးရမယ့် အပိုင်း)
|--------------------------------------------------------------------------
*/
// Breeze က default အနေနဲ့ 'auth' (Login ဝင်ပြီး) + 'verified' (Email verify လုပ်ပြီး) 
// middleware group ကို သုံးပါတယ်။
Route::middleware(['auth', 'verified'])->group(function () {


    // (က) Default Dashboard (Login ဝင်ပြီးချင်း ရောက်မယ့်နေရာ)
    // Login ဝင်ပြီးရင် /budget (Budget App) ဆီကို တန်းလွှဲပေးပါမယ်။
    Route::get('/dashboard', function () {
        return redirect()->route('budget.index');
    })->name('dashboard');

    // (ခ) Budget App Routes
    // URL အားလုံးကို '/budget' prefix နဲ့ ပြောင်းထားပါတယ်
    Route::get('/budget', [BudgetController::class, 'index'])->name('budget.index');
    Route::post('/budget/transaction', [BudgetController::class, 'store'])->name('budget.store');
    Route::delete('/budget/transaction/{transaction}', [BudgetController::class, 'destroy'])->name('budget.destroy');

    // (ဂ) User Profile Page (Breeze က ထည့်ထားတာ)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/players/{player:ign}', [PublicController::class, 'showPlayerProfile'])->name('public.player.profile');

});


/*
|--------------------------------------------------------------------------
| Breeze's Authentication Routes (Login, Register, etc.)
|--------------------------------------------------------------------------
*/
// ဒီ file က Login, Register, Forgot Password စာမျက်နှာတွေအတွက် လိုအပ်ပါတယ်
// ဒါကို မထိပါနဲ့
require __DIR__.'/auth.php';

