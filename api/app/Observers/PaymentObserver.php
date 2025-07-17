<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    public function saved(Payment $payment)
    {
        if ($payment->wasChanged('status')) 
        {
            switch ($payment->status) 
            {
                case 'completed':
                {
                    $payment->contract->user->contracts()->update(['is_active' => false]);
                    
                    $contract = $payment->contract;
                    $contract->is_active = true;
                    if (!$contract->started_at) $contract->started_at = \Carbon::now();
                    if (!$contract->ended_at) $contract->ended_at = \Carbon::now()->addMonth();
                    $contract->save();
                }
                break;

                default: $payment->contract->update(['is_active' => false]);
                break;
            }
        }
    }
}
