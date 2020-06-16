@extends('layouts.app')

@section('content')
<form id="formCustomerImportCSV" action="{{ url('customers/import') }}" style="display: none;" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" id="customerCSV" name="customerCSV" onchange="importCSV()" />
</form>

<h2>Clientes</h2>
<div class="row-filters row">
    <form class="col-12" id="formSearch" method="post">
        {!! csrf_field() !!}
        <div class="form-row col-12">
            <div class="col-md-3 col-sm-3 col-xs-12">
            <input id="search" name="search" value="{{ $request->search ?: ''  }}" class="form-control" type="text"
                    placeholder="Busca Livre...">
                <small>Ex: Nome, E-mail, Logradouro ou Bairro</small>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button type="submit" class="btn btn-success">
                    Pesquisar
                </button>
                <button type="submit" class="btn btn-info" name="exportCSV" value="CSV">
                    Exportar CSV
                </button>
                <button type="button" class="btn btn-secondary" name="importCSV" id="importCSV" value="CSV" onclick="document.getElementById('customerCSV').click();">
                    Importar CSV
                </button>
            <button type="buttons" class="btn btn-danger" name="deleteALl" value="DEL" onclick="if(confirm('Você tem certeza que deseja APAGAR TODOS OS CLIENTES?')) { window.location='{{ url('customers/delete-all') }}' };return false;">
                    Apagar Clientes
                </button>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data Nascimento</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                    <th>Lat / Long</th>
                    <th>Distância</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ isset($customer->date_birth) ? $customer->date_birth->format('d/m/Y') : '' }}</td>
                    <td>{{ $customer->cpf }}</td>
                    <td>{{ isset($customer->Address) ? $customer->Address->getFullAddress() : '' }}</td>
                    <td>
                        {{ isset($customer->Address) ? $customer->Address->latitude : '' }}
                        /
                        {{ isset($customer->Address) ? $customer->Address->longitude : '' }}
                    </td>
                    <td>{{ isset($customer->Address) ? number_format($customer->Address->distance/1000, 2) : '' }} Km</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $customers->render() }}
</div>
@if(count($directions) >0)
<div class="row">
    <h2>Melhor Rota:</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Local de Inicio</th>
                    <th>Destino</th>
                    <th>Distância</th>
                    <th>Duração</th>
                </tr>
            </thead>
            <tbody>
            @foreach($directions as $step)
                <tr>
                    <td>{{ $step->start_address }}</td>
                    <td>{{ $step->end_address }}</td>
                    <td>{{ $step->distance->text }}</td>
                    <td>{{ $step->duration->text }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script type="text/javascript">
    function importCSV(){
        if(confirm('Você tem certeza que deseja importar este arquivo CSV?')) {
            document.getElementById('formCustomerImportCSV').submit();
        }
    }
</script>

@endsection