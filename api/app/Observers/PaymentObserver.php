<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    public function updated(Payment $payment)
    {
        Payment::withoutEvents(function () use ($payment) 
        {
            if ($payment->wasChanged('status')) 
            {
                $contract = $payment->contract;

                switch ($payment->status) 
                {
                    case 'completed':
                    {
                        $contract->user->contracts()->whereNot('id', $contract->id)->update(['is_active' => false]);
                        $contract->is_active = true;
                        if (!$contract->started_at) $contract->started_at = \Carbon::now();
                        if (!$contract->ended_at) $contract->ended_at = \Carbon::now()->addMonth();
                        else $contract->ended_at = $contract->ended_at->addMonth();
                        $contract->save();
                    }
                    break;

                    default: $contract->update(['is_active' => false]);
                    break;
                }
            }
        });
    }
}
