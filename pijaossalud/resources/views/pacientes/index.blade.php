@extends('layout')

@section('content')
    <div class="container">
        <button class="btn btn-primary float-right shadow" data-toggle="modal" data-target="#crear-paciente"><i class="fas fa-plus"></i> Crear</button>
        <div class="page-header">
            <h2><i class="fas fa-users"></i> Pacientes</h2>
        </div>
        <hr>
        <div class="container shadow">
            <br>
            <table class="table table-bordered data-tablepacientes table-sm responsive" style="width:100%;" align="center">
                <thead>
                    <tr>
                        <th width="200px">Fecha</th>
                        <th>Tipo</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Nacimiento</th>
                        <th>Email</th>
                        <th width="250px">Accion</th>
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
@include('pacientes.create')
@include('pacientes.edit')
@section('scripts')
    <script src="{{ asset('js/pacientes.js') }}"></script>
@endsection
