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
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'float',
        'discount' => 'float',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}