@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Simple Datatable</div>

                <div class="card-body">
                    @simpleDatatable(['data' => $users, 'view' => simple_table_view('users')])
                    @endsimpleDatatable

                    @simplePaginator(['data' => $users, 'appends' => ['name' => 'cuong.ngo']])
                    @endsimplePaginator
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

