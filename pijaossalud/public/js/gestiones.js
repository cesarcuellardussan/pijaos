$(document).ready(function() {
    $('#datetimepicker1, #datetimepicker1_edit').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD HH:mm:ss',
    });
    $('#datetimepicker2, #datetimepicker2_edit').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false
    });
    $("#datetimepicker1, #datetimepicker1_edit").on("change.datetimepicker", function (e) {
        $('#datetimepicker2, #datetimepicker2_edit').datetimepicker('minDate', e.date);
    });
    $("#datetimepicker2, #datetimepicker2_edit").on("change.datetimepicker", function (e) {
        $('#datetimepicker1, #datetimepicker1_edit').datetimepicker('maxDate', e.date);
    });
    $('#no_doc_paciente, #no_doc_paciente_edit').selectpicker();
    $('#cod_hospital, #cod_hospital_edit').selectpicker();
});

var tabla;
atributosDatatable.columns = [
    {data: 'id_hospitalizacion', name: 'id_hospitalizacion'},
    {data: 'fec_creacion', name: 'fec_creacion'},
    {data: 'tipo_doc_paciente', name: 'tipo_doc_paciente'},
    {data: 'no_doc_paciente', name: 'no_doc_paciente'},
    {data: 'cod_hospital', name: 'cod_hospital'},
    {data: 'fec_ingreso', name: 'fec_ingreso'},
    {data: 'fec_salida', name: 'fec_salida'},
    {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false},
];
tabla = $('.data-tablegestiones').DataTable(atributosDatatable);
tabla.ajax.url("/gestiones").load();

function indexGestiones(){
    tabla.ajax.url("/gestiones").load();
}

function createGestion(){
    fetch('/gestiones/create', {
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
        $('#datetimepicker1, #datetimepicker2').datetimepicker('clear');
        $('.selectpicker option').not('[value=""]').remove();
        $.each(data.paciente, function(index, opcion) {
            $('#no_doc_paciente').append($('<option>', {
                value: opcion.no_documento,
                text: opcion.nombres+" "+opcion.apellidos+" - "+opcion.tipo_documento+" - "+opcion.no_documento
            }));
        });
        $.each(data.hospital, function(index, opcion) {
            $('#cod_hospital').append($('<option>', {
                value: opcion.cod_hospital,
                text: opcion.cod_hospital+" - "+opcion.nombre
            }));
        });
        $('.selectpicker').selectpicker('refresh');
    })
    .catch(error => {
        console.error(error);
    });
}

function storeGestion(){

    let fec_ingreso = $("#fecha-ingreso").val();
    let fec_salida = $("#fecha-salida").val();
    let no_doc_paciente = $("#no_doc_paciente").val();
    let cod_hospital = $("#cod_hospital").val();

    fetch('/gestiones', {
        method: 'POST',
        body: JSON.stringify({
            fec_ingreso     : fec_ingreso,
            fec_salida      : fec_salida,
            no_doc_paciente : no_doc_paciente,
            cod_hospital    : cod_hospital,
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
            $("#form-create-gestion")[0].reset();
            $('#crear-gestion').modal('hide');
        }
        indexGestiones();
    })
    .catch(error => {
        console.error(error);
    });
}

function editGestion(id_hospitalizacion){
    fetch('/gestiones/'+id_hospitalizacion+'/edit', {
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
        $('#datetimepicker1_edit, #datetimepicker2_edit').datetimepicker('clear');
        $('.selectpicker option').not('[value=""]').remove();
        $.each(data.pacientes, function(index, opcion) {
            $('#no_doc_paciente_edit').append($('<option>', {
                value: opcion.no_documento,
                text: opcion.nombres+" "+opcion.apellidos+" - "+opcion.tipo_documento+" - "+opcion.no_documento
            }));
        });
        $.each(data.hospitales, function(index, opcion) {
            $('#cod_hospital_edit').append($('<option>', {
                value: opcion.cod_hospital,
                text: opcion.cod_hospital+" - "+opcion.nombre
            }));
        });
        $('.selectpicker').selectpicker('refresh');
        $('#no_doc_paciente_edit').val(data.gestion.no_doc_paciente);
        $('#cod_hospital_edit').val(data.gestion.cod_hospital);
        $('.selectpicker').selectpicker('refresh');
        $('#datetimepicker1_edit').datetimepicker('date', data.gestion.fec_ingreso);
        $('#datetimepicker2_edit').datetimepicker('date', data.gestion.fec_salida);
        $("#update-gestion").data('id-hospitalizacion',id_hospitalizacion);
        $('#edit-gestion').modal('show');
    })
    .catch(error => {
        console.error(error);
    });
}

function updateGestion(){
    let id_hospitalizacion = $("#update-gestion").data('id-hospitalizacion');
    let formArray = $('#form-edit-gestion').serializeArray();
    let formData = {};
    $.map(formArray, function(n, i){
        formData[n['name']] = n['value'];
    });
    formData['fecha_ingreso_edit'] = $("#fecha-ingreso_edit").val();
    formData['fecha_salida_edit'] = $("#fecha-salida_edit").val();
    // console.log(formData);
    // return;
    fetch('/gestiones/'+id_hospitalizacion, {
        method: 'PUT',
        body: JSON.stringify({
            no_doc_paciente : formData.no_doc_paciente_edit,
            cod_hospital    : formData.cod_hospital_edit,
            fec_ingreso     : formData.fecha_ingreso_edit,
            fec_salida      : formData.fecha_salida_edit
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
            $('#edit-gestion').modal('hide');
        }
        indexGestiones();
    })
    .catch(error => {
        console.error(error);
    });
}

function deleteGestion(no_documento){

    Swal.fire({
        title: '¿Está seguro que desea eliminar la gestion?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/gestiones/'+no_documento, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(data => {
                indexGestiones();
                Swal.fire(data.title,data.text,data.icon);
            })
            .catch(error => {
                console.error(error);
            });
        }
    })
}
