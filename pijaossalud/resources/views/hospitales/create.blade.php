<div class="modal fade" id="crear-hospital" tabindex="-1" role="dialog" aria-labelledby="crear-hospitalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crear-hospitalLabel"><i class="fas fa-plus"></i> Crear Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="form-create-hospital">
                        <div class="form-group">
                          <label for="cod_hospital">Código</label>
                          <input type="text" class="form-control" id="cod_hospital" name="cod_hospital">
                        </div>
                        <div class="form-group">
                          <label for="nombre_hospital">Nombre</label>
                          <input type="text" class="form-control" id="nombre_hospital" name="nombre_hospital">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cerrar</button> --}}
                <button type="button" class="btn btn-primary" onclick="storeHospital()">Crear</button>
            </div>
        </div>
    </div>
</div>
