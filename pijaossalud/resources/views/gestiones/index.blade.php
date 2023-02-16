@extends('layout')

@section('content')
    <div class="container">
        <button class="btn btn-primary float-right shadow" data-toggle="modal" data-target="#crear-gestion" onclick="createGestion()"><i class="fas fa-plus"></i> Crear</button>
        <div class="page-header">
            <h2><i class="fas fa-tasks"></i> Gestiones</h2>
        </div>
        <hr>
        <div class="container shadow">
            <br>
            <table class="table table-bordered data-tablegestiones table-sm responsive" style="width:100%;" align="center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th width="150px">Fecha Creacion</th>
                        <th>Tipo</th>
                        <th>Documento</th>
                        <th>Cod. Hospital</th>
                        <th>Fec. Ingreso</th>
                        <th>Fec. Salida</th>
                        <th width="200px">Accion</th>
                        {{-- <th>Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <br>
        </div>
    </div>
@endsection
@include('gestiones.create')
@include('gestiones.edit')
@section('scripts')
    <script src="{{ asset('js/gestiones.js') }}"></script>
@endsection
