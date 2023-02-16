<div class="modal fade" id="crear-gestion" tabindex="-1" role="dialog" aria-labelledby="crear-gestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crear-gestionLabel"><i class="fas fa-plus"></i> Crear Gestion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-create-gestion">
                        <div class="form-group">
                            <label for="no_doc_paciente">Paciente</label>
                            <select class="form-control selectpicker"  data-live-search="true" id="no_doc_paciente" name="no_doc_paciente">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cod_hospital">Hospital</label>
                            <select class="form-control selectpicker" data-live-search="true" id="cod_hospital" name="cod_hospital">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="form-group col">
                                <label for="fecha-ingreso">Fecha de ingreso:</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="fecha-ingreso" data-target="#datetimepicker1" />
                                  <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                </div>
                              </div>

                              <div class="form-group col">
                                <label for="fecha-salida">Fecha de salida:</label>
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" id="fecha-salida" data-target="#datetimepicker2" />
                                  <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
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
                <button type="button" class="btn btn-primary" onclick="storeGestion()">Crear</button>
            </div>
        </div>
    </div>
</div>
