<div class="modal fade" id="crear-paciente" tabindex="-1" role="dialog" aria-labelledby="crear-pacienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crear-pacienteLabel"><i class="fas fa-plus"></i> Crear Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-create-paciente">
                        <div class="row">
                            <div class="form-group col">
                                <label for="tipo_documento">Tipo Documento</label>
                                <select class="form-control" id="tipo_documento" name="tipo_documento">
                                    <option value="">Seleccione</option>
                                    <option value="RC">Registro civil</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="CC">Cédula de ciudadanía</option>
                                    <option value="CE">Cédula de extranjería</option>
                                </select>
                            </div>

                            <div class="form-group col">
                                <label for="no_documento">Documento</label>
                                <input type="text" class="form-control" id="no_documento" name="no_documento">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres">
                        </div>

                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos">
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="fec_nacimiento">Fecha nacimiento</label>
                                <input type="date" class="form-control" id="fec_nacimiento" name="fec_nacimiento">
                            </div>

                            <div class="form-group col">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button> --}}
                <button type="button" class="btn btn-primary" onclick="storePaciente()">Crear</button>
            </div>
        </div>
    </div>
</div>
