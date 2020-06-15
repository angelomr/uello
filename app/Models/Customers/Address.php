<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'customer_id',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'cep',
        'latitude',
        'longitude',
        'distance'
    ];

    public function Customer()
    {
        return $this->belongsTo('App\Models\Customers\Customer', 'customer_id');
    }
}