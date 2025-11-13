<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PublicController;



/*
|--------------------------------------------------------------------------
| Public Website Routes (Login မလိုသူ၊ ပရိသတ် ကြည့်ရန်)
|--------------------------------------------------------------------------
|
| ဒါက ပင်မ Website (Bootstrap ဒီဇိုင်း) အတွက် လမ်းကြောင်းတွေပါ
|
*/
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/roster', [PublicController::class, 'showRoster'])->name('public.roster');
Route::get('/players/{player:ign}', [PublicController::class, 'showPlayerProfile'])->name('public.player.profile');


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Breeze/Filament Core)
|--------------------------------------------------------------------------
|
| ဒီ route တွေက Filament Admin Panel ရဲ့ Login/Logout/Password Reset 
| တွေ အလုပ်လုပ်ဖို့ လိုအပ်ပါတယ်
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // (၁) Login ဝင်ပြီးသား user က /dashboard ကို တိုက်ရိုက် ဝင်လာခဲ့ရင်
    // Admin Panel (/admin) ဆီကိုပဲ တန်းလွှဲပေးပါ
    Route::get('/dashboard', function () {
        return redirect('/admin');
    })->name('dashboard');

    // (၂) Budget App နဲ့ Profile Page အဟောင်းတွေ အားလုံးကို ဖယ်ရှားလိုက်ပါပြီ

});


/*
|--------------------------------------------------------------------------
| Breeze's Authentication Routes (Login, Register, etc.)
|--------------------------------------------------------------------------
|
| (အလွန်အရေးကြီး) ဒီ file ကို လုံးဝ မဖျက်ပါနဲ့။ 
| ဒါက /admin/login အလုပ်လုပ်ဖို့ လိုအပ်ပါတယ်။
|
*/

require __DIR__.'/auth.php';

