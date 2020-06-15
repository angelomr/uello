<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'date_birth'
    ];

    protected $dates = [
        'date_birth'
    ];

    public function scopeFilters($query)
    {
        global $request;

        if (isset($request->search) && $request->search!="") {
            $query = $query->where(function ($q) use ($request) {
                $q = $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                ;
            });
        }
        //dd($request->all());

        return $query;
    }

    public function Address()
    {
        return $this->hasOne('App\Models\Customers\Address', 'customer_id');
    }

}