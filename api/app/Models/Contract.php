<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    protected $fillable = [
        'user_id',
        'plan_id',
        'is_active',
        'value',
        'discount',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'discount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}