<div class="modal fade" id="edit-hospital" tabindex="-1" role="dialog" aria-labelledby="edit-hospitalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-hospitalLabel"><i class="fas fa-edit"></i> Actualizar Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-update-hospital">
                        <div class="form-group">
                          <label for="cod_hospital_edit">Código</label>
                          <input type="text" class="form-control" id="cod_hospital_edit" name="cod_hospital_edit">
                        </div>
                        <div class="form-group">
                          <label for="nombre_hospital_edit">Nombre</label>
                          <input type="text" class="form-control" id="nombre_hospital_edit" name="nombre_hospital_edit">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button> --}}
                <button type="button" class="btn btn-primary" onclick="updateHospital(this)" data-cod-hospital="" data-nombre-hospital="" id="update-hospital">Actualizar</button>
            </div>
        </div>
    </div>
</div>
