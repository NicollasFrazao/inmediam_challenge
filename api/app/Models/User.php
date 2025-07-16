<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $hidden = ['created_at', 'updated_at'];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function currentContract()
    {
        return $this->contracts()
                    ->where('is_active', true)
                    ->with('plan')
                    ->first();
    }

    public function getCurrentContractAttribute()
    {
        return $this->currentContract();
    }
}
