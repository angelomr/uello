@extends('layouts.app')

@section('content')
<form id="formCustomerImportCSV" action="{{ url('customers/import') }}" style="display: none;" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="file" id="customerCSV" name="customerCSV" onchange="importCSV()" />
</form>

<div class="row-filters row">
    <form class="col-12" id="formSearch" method="post">
        {!! csrf_field() !!}
        <div class="form-row col-12">
            <div class="col-md-3 col-sm-3 col-xs-12">
            <input id="search" name="search" value="{{ $request->search ?: ''  }}" class="form-control" type="text"
                    placeholder="Busca Livre...">
                <small>Ex: Nome ou E-mail</small>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-search"></i> 
                    Pesquisar
                </button>
                <button type="submit" class="btn btn-info" name="exportCSV" value="CSV">
                    <i class="fa fa-file-excel-o"></i>
                    Exportar CSV
                </button>
                <button type="button" class="btn btn-secondary" name="importCSV" id="importCSV" value="CSV" onclick="document.getElementById('customerCSV').click();">
                    <i class="fa fa-file-excel-o"></i>
                    Importar CSV
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $customers->render() }}
</div>
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