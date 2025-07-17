<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $fillable = [
        'description',
        'numberOfClients',
        'gigabytesStorage',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'float',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
