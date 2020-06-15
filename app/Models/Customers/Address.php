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

    public function Parse($data)
    {
        $extract = explode(', ', $data);
        $other = explode(' - ', $extract[1]);
        $address = new \stdClass();
        $address->address = $extract[0];
        $number = trim($other[0]);
        $address->number = substr($number, 0, strpos(' ', $number) > 0 ? strpos(' ', $number) : strlen($number));
        $address->complement = strpos(' ', $number) > 0 ? substr($number, -(strlen($number)-strpos(' ', $number))) : '';
        $address->neighborhood = $other[1];
        $address->city = $other[2];
        return $address;        
    }

    public function getFullAddress() 
    {
        return "{$this->address}, {$this->number} {$this->complement} - {$this->neighborhood} - {$this->city}";
    }
}