<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function process(Request $request, $transaction_id)
    {
        if ($payment = Payment::where('transaction_id', $transaction_id)->first()) 
        {
            $input = $request->validate(['status' => Payment::$rules['status']]);
            $payment->update($input);

            return response()->json(['success' => true, 'message' => 'Pagamento atualizado com sucesso!', 'payment' => $payment]);
        }
        else return response()->json(['success' => false, 'message' => 'Pagamento não encontrado!'])->setStatusCode(404);
    }
}