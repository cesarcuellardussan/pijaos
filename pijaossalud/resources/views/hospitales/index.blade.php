@extends('layout')

@section('content')
    <div class="container">
        <button class="btn btn-primary float-right shadow" data-toggle="modal" data-target="#crear-hospital"><i class="fas fa-plus"></i> Crear</button>
        <div class="page-header">
            <h2><i class="fas fa-hospital-alt"></i> Hospitales</h2>
        </div>
        <hr>
        <div class="container shadow">
            <br>
            <table class="table table-bordered data-tablehospitales table-sm responsive" style="width:100%;" align="center">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        {{-- <th width="100px">Accion</th> --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <br>
        </div>
    </div>
@endsection
@include('hospitales.create')
@include('hospitales.edit')
@section('scripts')
    <script src="{{ asset('js/hospitales.js') }}"></script>
@endsection
