<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'contract_id',
        'transaction_id',
        'status',
        'value',
    ];

    protected $casts = [
        'value' => 'float',
        'transaction_id' => 'string',
        'status' => 'string',
    ];

    public static $rules = [
        'user_id'        => 'required|exists:users,id',
        'contract_id'    => 'required|exists:contracts,id',
        'transaction_id' => 'required|uuid|unique:payments,transaction_id',
        'status'         => 'required|in:pending,completed,failed',
        'value'          => 'required|numeric|min:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}