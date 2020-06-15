@if(Session::has('flash_message'))
<div class="row">
    <div class="alert alert-success col-12">
        {!! Session::get('flash_message') !!}
    </div>
</div>
@endif
@if(Session::has('error_message'))
<div class="row">
    <div class="alert alert-danger col-12">
        {!! Session::get('error_message') !!}
    </div>
</div>
@endif