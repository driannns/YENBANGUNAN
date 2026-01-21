<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyFormula;
use App\Models\LoyaltyHistory;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    public function formula()
    {
        $formula = LoyaltyFormula::first(); // Assuming there's only one formula

        return view('loyalty-formula', compact('formula'));
    }

    public function log()
    {
        // Only manager can access loyalty log
        if (!auth()->user()->is_manager) {
            abort(403, 'Unauthorized');
        }

        $loyaltyHistories = LoyaltyHistory::with(['order', 'user'])->orderBy('created_at', 'desc')->get();

        return view('loyalty-log', compact('loyaltyHistories'));
    }
}