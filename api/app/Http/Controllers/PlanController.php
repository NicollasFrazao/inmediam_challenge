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
        $value = $plan->price;

        \DB::beginTransaction();
        
        if ($current_contract = $user->current_contract) 
        {
            $days_of_use = $current_contract->started_at ? $current_contract->started_at->diffInDays(\Carbon\Carbon::now()) : 0;
            $days_of_contract = $current_contract->started_at->diffInDays($current_contract->ended_at);
            
            $discount = $current_contract->value - (($days_of_contract > 0) ? ($current_contract->value*$days_of_use)/$days_of_contract : 0);
        }
        else $discount = 0;

        $contract = $user->contracts()->create([
            'plan_id' => $plan->id,
            'is_active' => false,
            'value' => $value,
            'discount' => $discount,
        ]);

        $payment = $contract->payments()->create([
            'user_id' => $user->id,
            'transaction_id' => \Str::uuid(),
            'status' => 'pending',
            'value' => $value - $discount,
        ]);

        \DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Efetue o pagamento para confirmar a contratação do plano.', 
            'payment' => $payment
        ]);
    }
}
