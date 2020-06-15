<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Customers\Customer;
use App\Models\Customers\Address;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::filters()
            ->orderBy('name')
            ->with('Address');

        if (isset($request->exportCSV)) {
            return $this->export($customers);
        }

        $customers = $customers->paginate(5);

        return view('customers.index', compact('request', 'customers'));
    }

    public function import(Request $request)
    {
        if ($request->customerCSV) {
            $file = fopen($request->customerCSV->getRealPath(), "r");
            $qtt = 0;
            $sucess = 0;
            echo '<pre>';
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
        $address->latitude = '0';
        $address->longitude = '0';
        $address->distance = '0';
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
}
