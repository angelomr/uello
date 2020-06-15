nome;email;datanasc;cpf;endereco;cep
@foreach($customers as $customer)
{{ $customer->name }};{{ $customer->email }};{{ isset($customer->date_birth) ? $customer->date_birth->format('d/m/Y') : '' }};{{ $customer->cpf }};{{ isset($customer->Address) ? $customer->Address->getFullAddress() : '' }};{{ $customer->Address->cep ?: '' }};
@endforeach