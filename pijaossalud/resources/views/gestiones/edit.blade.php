<div class="modal fade" id="edit-gestion" tabindex="-1" role="dialog" aria-labelledby="edit-gestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-gestionLabel"><i class="fas fa-edit"></i> Actualizar Gestion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-edit-gestion">
                        <div class="form-group">
                            <label for="no_doc_paciente_edit">Paciente</label>
                            <select class="form-control selectpicker"  data-live-search="true" id="no_doc_paciente_edit" name="no_doc_paciente_edit">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cod_hospital_edit">Hospital</label>
                            <select class="form-control selectpicker" data-live-search="true" id="cod_hospital_edit" name="cod_hospital_edit">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fecha-ingreso_edit">Fecha de ingreso paciente:</label>
                                <div class="input-group date" id="datetimepicker1_edit" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="fecha-ingreso_edit" data-target="#datetimepicker1_edit" />
                                  <div class="input-group-append" data-target="#datetimepicker1_edit" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group col-md-6">
                                <label for="fecha-salida_edit">Fecha de salida paciente:</label>
                                <div class="input-group date" id="datetimepicker2_edit" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="fecha-salida_edit" data-target="#datetimepicker2_edit" />
                                  <div class="input-group-append" data-target="#datetimepicker2_edit" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button> --}}
                <button type="button" class="btn btn-primary" onclick="updateGestion()" data-id-hospitalizacion="" id="update-gestion">Actualizar</button>
            </div>
        </div>
    </div>
</div>
