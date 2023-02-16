<div class="modal fade" id="edit-paciente" tabindex="-1" role="dialog" aria-labelledby="edit-pacienteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-pacienteLabel"><i class="fas fa-edit"></i> Actualizar Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-edit-paciente">
                        <div class="row">
                            <div class="form-group col">
                                <label for="tipo_documento_edit">Tipo Documento</label>
                                <select class="form-control" id="tipo_documento_edit" name="tipo_documento_edit">
                                    <option value="">Seleccione</option>
                                    <option value="RC">Registro civil</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="CC">Cédula de ciudadanía</option>
                                    <option value="CE">Cédula de extranjería</option>
                                </select>
                            </div>

                            <div class="form-group col">
                                <label for="no_documento_edit">Documento</label>
                                <input type="text" class="form-control" id="no_documento_edit" name="no_documento_edit">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nombres_edit">Nombres</label>
                            <input type="text" class="form-control" id="nombres_edit" name="nombres_edit">
                        </div>

                        <div class="form-group">
                            <label for="apellidos_edit">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos_edit" name="apellidos_edit">
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="fec_nacimiento_edit">Fecha nacimiento</label>
                                <input type="date" class="form-control" id="fec_nacimiento_edit" name="fec_nacimiento_edit">
                            </div>

                            <div class="form-group col">
                                <label for="email_edit">Email</label>
                                <input type="email_edit" class="form-control" id="email_edit" name="email_edit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button> --}}
                <button type="button" class="btn btn-primary" onclick="updatePaciente()" data-no-documento="" id="update-paciente">Actualizar</button>
            </div>
        </div>
    </div>
</div>
