<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Customers\Customer;
use App\Models\Customers\Address;
use App\Services\Google;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $directions = [];

        $customers = Customer::filters()
            ->select('customers.*', \DB::raw('(SELECT distance FROM addresses WHERE customer_id = customers.id LIMIT 1) as distance'))
            ->orderBy('distance')
            ->with('Address');

        if (isset($request->exportCSV)) {
            return $this->export($customers);
        }

        $customers = $customers->paginate(5);

        $addresses = [];
        foreach ($customers as $customer) {
            if (isset($customer->Address)) {
                $addresses[] = $customer->Address;
            }
        }
        // dd($addresses);
        if (count($addresses) > 0) {
            $addresses = Collect($addresses);
            $directions = Google::getDirections($addresses);
            // dd(Google::getDistance(implode('|', $addresses)));
        }


        return view('customers.index', compact('request', 'customers', 'directions'));
    }

    public function import(Request $request)
    {
        if ($request->customerCSV) {
            $file = fopen($request->customerCSV->getRealPath(), "r");
            $qtt = 0;
            $sucess = 0;
            while (($row = fgetcsv($file, 10000, ";")) !== FALSE) {
                if ($qtt > 0 && trim($row[0]) != "") {
                    $customer = $this->save($row);
                    $this->saveAddress($customer->id, $row);
                    $sucess++;
                }
                $qtt++;
            }
            
            session()->flash('flash_message', "<h2>Importado com sucesso!</h2> Linhas importadas: {$sucess}");
            return redirect('customers');
        } else {
            session()->flash('error_message', "<h2>Arquivo Não Informado!</h2>");
            return redirect('customers');
        }
    }

    private function checkExists($cpf)
    {
        // Aqui deveria verificar se o cliente já está cadastrado, porém nos dados do CSV enviado de exemplo, os clientes tem o mesmo CPF, então a validação deste campo será ignorado.
        $cpf = str_replace(['.', '-'], "", $cpf);
        $customer = new Customer();
        $customer->cpf = $cpf;
        // $customer = Customer::firstOrNew(['cpf' => $cpf]);
        return $customer;
    }

    private function save($data)
    {
        $customer = $this->checkExists($data[3]);
        $customer->name = $data[0];
        $customer->email = $data[1];
        $customer->date_birth = Carbon::createFromFormat('d/m/Y', $data[2]);
        $customer->save();
        return $customer;
    }

    private function saveAddress($customer_id, $data)
    {
        $address = Address::firstOrNew(['customer_id' => $customer_id]);
        $address->customer_id = $customer_id;
        $address->cep = $data[5];
        $parse = $address->Parse($data[4]);
        $address->address = $parse->address;
        $address->number = $parse->number;
        $address->complement = $parse->complement;
        $address->neighborhood = $parse->neighborhood;
        $address->city = $parse->city;
        $coordinates = Google::getLatLong($data[4]);
        if (isset($coordinates->results[0]->geometry->location)) {
            $address->latitude = $coordinates->results[0]->geometry->location->lat;
            $address->longitude = $coordinates->results[0]->geometry->location->lng;
        } else {
            $address->latitude = '0';
            $address->longitude = '0';
        }
        $distance = Google::getDistance($data[4]);
        // dd($distance);
        $address->distance = $distance->rows[0]->elements[0]->distance->value ?: 0;
        $address->save();
    }

    public function export($customers)
    {
        $customers = $customers->get();
        
        header('Content-Type:text/csv;charset=UTF-8');
        header('Content-Disposition:attachment; filename=clientes.csv');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        return view('customers.csv', compact('customers'))->render();
    }

    public function deleteAll()
    {
        Address::truncate();
        Customer::truncate();
        session()->flash('flash_message', "<h2>Clientes Apagados com sucesso!</h2>");
        return redirect('customers');
    }
}
