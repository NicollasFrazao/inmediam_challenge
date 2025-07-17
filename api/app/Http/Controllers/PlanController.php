<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;

class PlanController extends Controller
{
    /**
     * Display a listing of the plans.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Plan::all();
    }
    
    public function hire(Plan $plan)
    {
        $user = User::find(1);

        \DB::beginTransaction();
        
        if ($current_contract = $user->current_contract) {}
        else
        {
            $price = $plan->price;
            $discount = 0;
        }

        $contract = $user->contracts()->create([
            'plan_id' => $plan->id,
            'is_active' => false,
            'value' => $price,
            'discount' => $discount,
        ]);

        $payment = $contract->payments()->create([
            'user_id' => $user->id,
            'transaction_id' => \Str::uuid(),
            'status' => 'pending',
            'value' => $price,
        ]);
        
        \DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Efetue o pagamento para confirmar a contratação do plano.', 
            'payment' => $payment
        ]);
    }
}
