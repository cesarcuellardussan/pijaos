var tabla;
atributosDatatable.columns = [
    {data: 'fec_creacion', name: 'fec_creacion'},
    {data: 'tipo_documento', name: 'tipo_documento'},
    {data: 'no_documento', name: 'no_documento'},
    {data: 'nombres', name: 'nombres'},
    {data: 'apellidos', name: 'apellidos'},
    {data: 'fec_nacimiento', name: 'fec_nacimiento'},
    {data: 'email', name: 'email'},
    {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false},
];
tabla = $('.data-tablepacientes').DataTable(atributosDatatable);
tabla.ajax.url("/pacientes").load();

function indexPacientes(){
    tabla.ajax.url("/pacientes").load();
}

function storePaciente(){
    let tipo_documento = $("#tipo_documento").val();
    let no_documento   = $("#no_documento").val();
    let nombres        = $("#nombres").val();
    let apellidos      = $("#apellidos").val();
    let fec_nacimiento = $("#fec_nacimiento").val();
    let email          = $("#email").val();

    fetch('/pacientes', {
        method: 'POST',
        body: JSON.stringify({
            tipo_documento : tipo_documento,
            no_documento   : no_documento,
            nombres        : nombres,
            apellidos      : apellidos,
            fec_nacimiento : fec_nacimiento,
            email          : email,
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al procesar la solicitud: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire(data.title,data.text,data.icon);
        if (data.icon == "success") {
            $("#form-create-paciente")[0].reset();
            $('#crear-paciente').modal('hide');
        }
        indexPacientes();
    })
    .catch(error => {
        console.error(error);
    });
}

function editPaciente(no_documento){
    fetch('/pacientes/'+no_documento+'/edit', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al procesar la solicitud: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        $("#tipo_documento_edit").val(data.tipo_documento);
        $("#no_documento_edit").val(data.no_documento);
        $("#nombres_edit").val(data.nombres);
        $("#apellidos_edit").val(data.apellidos);
        $("#fec_nacimiento_edit").val(data.fec_nacimiento);
        $("#email_edit").val(data.email);
        $("#update-paciente").data('no-documento',data.no_documento);
        // $("#update-hospital").data('nombre-hospital',data.nombre);
        $('#edit-paciente').modal('show');
    })
    .catch(error => {
        console.error(error);
    });
}

function updatePaciente(){
    let no_documento = $("#update-paciente").data('no-documento');
    let formArray = $('#form-edit-paciente').serializeArray();
    let formData = {};
    $.map(formArray, function(n, i){
        formData[n['name']] = n['value'];
    });
    fetch('/pacientes/'+no_documento, {
        method: 'PUT',
        body: JSON.stringify({
            tipo_documento: formData.tipo_documento_edit,
            no_documento  : formData.no_documento_edit,
            nombres       : formData.nombres_edit,
            apellidos     : formData.apellidos_edit,
            fec_nacimiento: formData.fec_nacimiento_edit,
            email         : formData.email_edit
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al procesar la solicitud: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire(data.title,data.text,data.icon);
        if (data.icon == "success") {
            $('#edit-paciente').modal('hide');
        }
        indexPacientes();
    })
    .catch(error => {
        console.error(error);
    });
}

function deletePaciente(no_documento){

    Swal.fire({
        title: '¿Está seguro que desea eliminar el paciente?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/pacientes/'+no_documento, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(data => {
                indexPacientes();
                Swal.fire(data.title,data.text,data.icon);
            })
            .catch(error => {
                console.error(error);
            });
        }
    })
}
