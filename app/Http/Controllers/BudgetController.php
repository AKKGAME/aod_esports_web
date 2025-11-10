<?php
// app/Http/Controllers/BudgetController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; // <-- Auth ကို သုံးဖို့ ထည့်ပါ

class BudgetController extends Controller
{
    public function index()
    {
        // Login ဝင်ထားတဲ့ user ရဲ့ id ကို ယူမယ်
        $userId = Auth::id();

        // Transaction အားလုံးကို မယူတော့ဘဲ၊ user_id တူတဲ့ transaction တွေကိုပဲ ယူမယ်
        $transactions = Transaction::where('user_id', $userId)->latest()->get();

        // ကျန်တာတွေက အတူတူပါပဲ
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('budget', [
            'transactions' => $transactions,
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance'      => $balance,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:income,expense',
            'text'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Data ထည့်တဲ့အခါ၊ လက်ရှိ login ဝင်ထားတဲ့ user ရဲ့ id ကိုပါ ထည့်ပေးလိုက်ပါ
        Transaction::create([
            'type'   => $request->type,
            'text'   => $request->text,
            'amount' => $request->amount,
            'user_id' => Auth::id(), // <-- user_id ကိုပါ ထည့်ပြီး create လုပ်မယ်
        ]);

        return redirect()->route('budget.index');
    }

    /**
     * သတ်မှတ်ထားသော transaction ကို ဖျက်သိမ်းမည်။
     */
    public function destroy(Transaction $transaction)
    {
        // === လုံခြုံရေး စစ်ဆေးခြင်း (အရေးကြီး) ===
        // Login ဝင်ထားသူက ဒီ transaction ကို ပိုင်ဆိုင်သူ ဟုတ်၊ မဟုတ် စစ်ဆေးပါ။
        if (auth()->id() !== $transaction->user_id) {
            abort(403, 'Unauthorized action.'); // မပိုင်ဆိုင်ရင် Error 403 ပြပါ။
        }

        // 2. Data ကို Database ထဲက ဖျက်ပါ
        $transaction->delete();

        // 3. အောင်မြင်ကြောင်း message နဲ့အတူ ပင်မစာမျက်နှာကို ပြန်သွားပါ
        return redirect()->route('budget.index')
                         ->with('success', 'မှတ်တမ်းကို အောင်မြင်စွာ ဖျက်လိုက်ပါပြီ။');
    }
}