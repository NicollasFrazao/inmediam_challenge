<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Contract;

class ContractController extends Controller
{
    public function current()
    {
        $current_contract = ($user = User::find(1)) ? $user->current_contract : null;
        return response()->json($current_contract);
    }

    public function index()
    {
        $contracts = [];
        if ($user = User::find(1)) $contracts = $user->contracts()->with(['plan', 'payments'])->get();
        return response()->json($contracts);
    }
}