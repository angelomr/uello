<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customers\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::filters()->orderBy('name');
        
        $customers = $customers->with('Addresses')->paginate(5);

        return view('customers.index', compact('request', 'customers'));
    }
}
